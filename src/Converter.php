<?php

namespace WikitextToMarkdown;

use Exception;
use Guzzle\Service\Mediawiki\MediawikiApiClient;
use HTML_To_Markdown;

class Converter {

	public function __construct() {
		//todo use a custom wiki url?
		$this->wikiClient = MediawikiApiClient::factory( array( 'base_url' => 'http://en.wikipedia.org/w/api.php' ) );
		$this->htmlToMarkdown = new HTML_To_Markdown();
	}

	public function convert( $wikitext ) {
		$apiResult = $this->wikiClient->parse( array(
			'contentmodel' => 'wikitext',
			'prop' => 'text',
			'disablepp' => true,
			'disabletoc' => true,
			'text' => $wikitext,
		) );

		if( !array_key_exists( 'text', $apiResult['parse'] ) ) {
			throw new Exception( 'Failed to parse wikitext using the api' );
		}

		$html = $apiResult['parse']['text']['*'];

		$allowedTags = '';
		$allowedTags .= '<h1><h2><h3><h4><h5><h6>'; // header
		$allowedTags .= '<del><strike>'; // strikethrough
		$allowedTags .= '<b><i><br><p>'; // formatting
		$allowedTags .= '<ol><ul><li>'; // lists
		$allowedTags .= '<a>'; // links
		$allowedTags .= '<img>'; // images

		$html = strip_tags( $html, $allowedTags );

		$markdown = $this->htmlToMarkdown->convert( $html );
		return $markdown;
	}

} 