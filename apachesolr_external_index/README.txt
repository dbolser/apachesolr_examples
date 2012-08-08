Example module for using external data.

Use Solr 3.5.0 or 3.6.x and create a new core on your localhost/dev Solr sever named "ext"
such that is will be found at http://localhost:8983/solr/ext

Copy from the apachesolr module solr-conf/solrconfig-solr3x.xml to the core's conf/solrconfig.xml

Copy from this module schema.xml to the core's conf/schema.xml.

Load the example external data using curl:

curl "http://localhost:8983/solr/ext/update/csv?commit=true" --data-binary @genes.csv -H 'Content-type:text/plain; charset=utf-8'

Sample gene data exported from AceView at the National Library of Medicine,
http://www.ncbi.nlm.nih.gov/IEB/Research/Acembly/
see http://www.ncbi.nlm.nih.gov/About/disclaimer.html
