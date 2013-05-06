
# Each non-comment, non-blank line contains a regular expression
# prefixed by '+' or '-'.  The first matching pattern in the file
# determines whether a URL is included or ignored.  If no pattern
# matches, the URL is ignored.

# skip file: ftp: and mailto: urls
-^(file|ftp|mailto):

# skip URLs containing certain query characters.
# @todo - for Drupal do we want to exclude ? & =
-[*!@?=]

# skip URLs with slash-delimited segment that repeats 3+ times, to break loops
-.*(/[^/]+)/[^/]+\1/[^/]+\1/

# accept one domain or subdomain
+^http://<?php print $urlfilter_domain; ?>
