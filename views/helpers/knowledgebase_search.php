<?php
/**
 * KnowledgebaseSearch helper
 *
 * @package		knowledgebase
 * @subpackage	knowledgebase.views.helpers
 * @since		0.1
 * @author		Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseSearchHelper extends AppHelper {

	/**
	 * Included helpers
	 *
	 * @var array
	 */
	public $helpers = array('Text');
	
	/*
	 * Highlight options
	 * 
	 * @var	array
	 */
	private $_highlight_options = array(
		'format' => '<span class="highlight">\1</span>',
		'html' => true
	);
	
	/**
	 * Highlight text
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	string	text
	 * @param	string	query
	 * @return	string	Highlighted text
	 */
	public function _highlightText ($text='', $query='') {
		
		if (empty($text) || empty($query)) {
			return $text;
		}
		
		return $this->Text->highlight(
			$text,
			explode(' ', $query),
			$this->_highlight_options
		);
		
	}
	
	/**
	 * Highlight article title
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	string	title
	 * @param	string	query
	 * @return	string	Highlighted title
	 */
	public function highlightArticleTitle ($title='', $query='') {
		
		return $this->_highlightText($title, $query);
		
	}
	
	/**
	 * Highlight article body
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	string	body
	 * @param	string	query
	 * @return	string	Highlighted body
	 */
	public function highlightArticleBody ($body='', $query='') {
		
		if (empty($body) || empty($query)) {
			return $body;
		}
		
		App::import('Core', 'Sanitize');
		
		$body = html_entity_decode(Sanitize::html($body, array('remove' => true)));
		
		$first_word_found = '';
		
		foreach (explode(' ', $query) as $key => $word) {
			if (stripos($body, $word) !== false) {
				$first_word_found = $word;
				break;
			}
		}
		
		$body = $this->Text->excerpt($body, $first_word_found, 150);
		
		return $this->_highlightText($body, $query);
		
	}

}
?>