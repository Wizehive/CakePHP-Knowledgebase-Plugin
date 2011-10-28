<?php

App::import('Helper', array('Knowledgebase.KnowledgebaseSearch', 'Text'));

/**
 * KnowledgebaseSearch Helper Test Case
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.cases.models
 * @since       0.1
 * @see         KnowledgebaseSearchHelper
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseSearchHelperTestCase extends CakeTestCase {

	/**
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function start() {

		parent::start();

	}
	
	/**
	 * startTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function startTest () {
		
		$this->KnowledgebaseSearch =& new KnowledgebaseSearchHelper();
		$this->KnowledgebaseSearch->Text =& new TextHelper();
		
	}

	/**
	 * endTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function endTest () {
		
		unset($this->KnowledgebaseSearch);
		ClassRegistry::flush();
		
	}

	/**
	 * Test Instance Creation
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testInstanceSetup() {

		$this->assertIsA($this->KnowledgebaseSearch, 'Helper');

	}
	
	/**
	 * Test highlightArticleTitle
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testHighlightArticleTitle () {
		
		$result = $this->KnowledgebaseSearch->highlightArticleTitle(
			'Some title with words in it',
			''
		);
		
		$this->assertEqual(
			$result,
			'Some title with words in it',
			'The title should not be highlighted'
		);
		
		$result = $this->KnowledgebaseSearch->highlightArticleTitle(
			'Some title with words in it',
			'with words'
		);
		
		$this->assertEqual(
			$result,
			'Some title <span class="highlight">with</span> <span class="highlight">words</span> in it',
			'The "with words" portion of the title should have been highlighted'
		);
		
		$result = $this->KnowledgebaseSearch->highlightArticleTitle(
			'Some title with words in it',
			'word'
		);
		
		$this->assertEqual(
			$result,
			'Some title with <span class="highlight">word</span>s in it',
			'The "word" portion of the title should have been highlighted'
		);
		
	}
	
	/**
	 * Test highlightArticleBody
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testHighlightArticleBody () {
		
		$result = $this->KnowledgebaseSearch->highlightArticleBody(
			'Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. ',
			'non-existent'
		);
		
		$match_count = preg_match_all('%<span class="highlight">{1}\\w++</span>{1}?%', $result, $matches);
		
		$this->assertEqual($match_count, 0, 'No words should be highlighted in the excerpt');
		$this->assertEqual(strlen($result), 300, 'The excerpt should be 300 characters long');
		
		$result = $this->KnowledgebaseSearch->highlightArticleBody(
			'Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. ',
			'with words forever'
		);
		
		$match_count = preg_match_all('%<span class="highlight">{1}\\w++</span>{1}?%', $result, $matches);
		
		$this->assertEqual($match_count, 8, '10 words should be highlighted in the excerpt');
		$this->assertEqual(strlen($result), 423, 'The excerpt should be 423 characters long');
		
		$result = $this->KnowledgebaseSearch->highlightArticleBody(
			'Some really <span class="annoying-html">long&nbsp;&nbsp;</span> body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. 
			Some really long body with words in it that may go on forever. Some really long body with words in it that may go on forever. ',
			'with words forever'
		);
		
		$match_count = preg_match_all('%<span class="highlight">{1}\\w++</span>{1}?%', $result, $matches);
		
		$this->assertEqual($match_count, 8, '8 words should be highlighted in the excerpt');
		$this->assertEqual(strlen($result), 435, 'The excerpt should be 435 characters long');
		
		$html_entities_converted_properly = strpos($result, '&amp;nbsp;') === false ? true : false;
		
		$this->assertTrue($html_entities_converted_properly, 'HTML entities should be converted properly');
		
	}
	
}

?>