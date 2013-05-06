<?php
// PHP is stupid when handing XML:
print '<?xml version="1.0"?>';
print '<?xml-stylesheet type="text/xsl" href="configuration.xsl"?>'

/**
 * Template variables
 * $http_agent_name
 * $index_metadata is empty or "|metadata"
 * $index_static_fields is an array of strings in the format name:value
 */
?>
<configuration>
<!-- see nutch-default.xml for descriptions of properties -->

<property>
  <name>http.agent.name</name>
  <value><?php print $http_agent_name; ?></value>
</property>

<property>
  <name>plugin.includes</name>
  <value>protocol-http|urlfilter-(suffix|regex)|parse-(html|tika|metatags)|index-(static|basic|anchor<?php print $index_metadata; ?>)|scoring-opic|urlnormalizer-(pass|regex|basic)</value>
</property>

<property>
  <name>index.static</name>
  <value>entity_type:nutch.crawl,access__all:0,<?php print implode(',', $index_static_fields); ?></value>
  <description>
  comma-separated list of fields in the format name:value
  </description>
</property>


<property>
  <name>http.content.limit</name>
  <!-- increase to 2MB -->
  <value>2097152</value>
</property>


</configuration>
