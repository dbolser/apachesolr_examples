branched off from earlier versions of http://drupal.org/sandbox/cilefen/1858412

The project contains the files needed to add Apache Nutch crawls to an Apache
Solr index running the apachesolr Drupal schema. 

This allows you to add any non-Drupal web pages to the Solr index so they 
are searchable by the Drupal apachesolr module.

Requirements
------------
This configuration has been tested against:
* Solr 3.6.2 http://lucene.apache.org/solr/
* Nutch 1.6.0 http://nutch.apache.org/
* ApacheSolr module 7.x-1.2 http://drupal.org/project/apachesolr

Installation
------------

1. Download Nutch version 1.x (it looks as though Nutch 1.6 was just released).
   http://www.apache.org/dyn/closer.cgi/nutch/

2. Unzip the package and compile Nutch.

   * Run 'ant' to compile.

   * The build will create a directory named apache-nutch-1.x.x/runtime/local/.
     You run Nutch from that directory.

3. If you are unfamiliar with Nutch, read the tutorial: http://wiki.apache.org/nutch/NutchTutorial

4. Copy these files from this project to the apache-nutch-1.x.x/runtime/local/conf directory:

   * solrindex-mapping.xml
   * subcollections.xml
   * nutch-site.xml # or, add the settings from this file to an existing nutch-site.xml

5. If you read and understood the tutorial, you are ready to crawl and index.

  # Be sure to edit conf/regex-urlfilter.txt appropriately depending
  # on what you want to crawl and that you add a urls directory with seed files. 
  export JAVA_HOME=/usr/lib/jvm/jre-openjdk/
  bin/nutch crawl urls -dir crawl -solr http://localhost:8983/solr/ -depth 10 -topN 1000

  In my environment, I like to use linkrank, so crawling takes this form:

  # Be sure to edit conf/regex-urlfilter.txt appropriately depending
  # on what you want to crawl and that you add a urls directory with seed files. 
  export JAVA_HOME=/usr/lib/jvm/jre-openjdk/
  bin/nutch crawl urls -dir crawl -depth 10 -topN 1000
  bin/nutch webgraph -segmentDir crawl/segments/ -webgraphdb crawl/webgraphdb
  bin/nutch linkrank -webgraphdb crawl/webgraphdb
  bin/nutch scoreupdater -crawldb crawl/crawldb -webgraphdb crawl/webgraphdb
  bin/nutch solrindex http://localhost:8983/solr/ crawl/crawldb -linkdb crawl/linkdb -dir crawl/segments -deleteGone
  bin/nutch solrdedup http://localhost:8983/solr/

6. That's it--you should be able to search now.
