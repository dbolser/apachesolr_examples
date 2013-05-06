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

1. Download the build (bin) Nutch version 1.6+
   http://www.apache.org/dyn/closer.cgi/nutch/1.6/apache-nutch-1.6-bin.tar.gz

2. If you are unfamiliar with Nutch, read the tutorial: http://wiki.apache.org/nutch/NutchTutorial

3. Enable this module, set the path to the nutch files, and configure 1 or more sites

4. Use the "Generate" form to create nutch config for a site to crawl.

5. Make note of the URL in the message. If you look at that path, you should see
   a full set of nutch conf, including customized files:

   * nutch-site.xml 
   * solrindex-mapping.xml
   * regex-urlfilter.txt
   * suffix-urlfilter.txt
   * urls/seed.txt

5. If you read and understood the tutorial, you are ready to crawl and index.

  # Be sure to edit conf/regex-urlfilter.txt appropriately depending
  # on what you want to crawl and that you add a urls directory with seed files. 
  export JAVA_HOME=/usr/lib/jvm/jre-openjdk/

  # Use the path reported by the generate button, then these 2 command should
  # get you started with a crawl and index (set the right paths and Solr url).
  export NUTCH_CONF_DIR=/PATH/TO/DRUPAL/sites/mysite/files/apachesolr_multinutch/1
  bin/nutch crawl $NUTCH_CONF_DIR/urls -dir $NUTCH_CONF_DIR/crawl -depth 10 -topN 2000
  bin/nutch solrindex http://localhost:8983/solr/ $NUTCH_CONF_DIR/crawl/crawldb -dir $NUTCH_CONF_DIR/crawl/segments -deleteGone


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
