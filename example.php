<?php
require_once( __DIR__ . '/vendor/autoload.php' );

$wikitext = '== New section ==
A single
newline
has no
effect

But an empty line starts a new paragraph.

=== Subsection ===

You can break lines<br>
without starting a new paragraph.

<blockquote>
The \'\'\'blockquote\'\'\' command will indent
both margins when needed instead of the
left margin only as the colon does.
</blockquote>

==== Sub-subsection ====

* Unordered Lists are easy to do:
* Unordered Lists are easy to do2:
** start every line with a star

# Numbered lists are also good
## very organized
## easy to follow
';

$converter = new WikitextToMarkdown\Converter();
$markdown = $converter->convert( $wikitext );

echo $markdown;