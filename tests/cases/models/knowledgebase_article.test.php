<?php

/**
 * KnowledgebaseArticle Model Test Case
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.cases.models
 * @since       0.1
 * @see         KnowledgebaseArticle
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseArticleTestCase extends CakeTestCase {

	/**
     * @var     array
     */
    public $fixtures = array(
        'plugin.knowledgebase.knowledgebase_portal',
    	'plugin.knowledgebase.knowledgebase_article',
    	'plugin.knowledgebase.knowledgebase_articles_knowledgebase_category',
    	'plugin.knowledgebase.knowledgebase_category'
    );
	
	/**
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function start() {

		parent::start();
		
		// Bit of a hack, but the test suite doesn't support FULLTEXT indexes, so they need to be created manually for this test case
		ClassRegistry::init('Knowledgebase.KnowledgebaseArticle')->query("
		ALTER TABLE `knowledgebase_articles` 
		ADD FULLTEXT INDEX `title_body_idx` (`title`, `body`(100))
		");

	}
	
	/**
	 * startTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function startTest () {
		
		$this->KnowledgebaseArticle =& ClassRegistry::init('Knowledgebase.KnowledgebaseArticle');
		
	}

	/**
	 * endTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function endTest () {
		
		unset($this->KnowledgebaseArticle);
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

		$this->assertIsA($this->KnowledgebaseArticle, 'Model');
		$this->assertTrue(array_key_exists('KnowledgebasePortal', $this->KnowledgebaseArticle->belongsTo));
		$this->assertIsA($this->KnowledgebaseArticle->KnowledgebasePortal, 'Model');
		$this->assertTrue(array_key_exists('KnowledgebaseArticlesKnowledgebaseCategory', $this->KnowledgebaseArticle->hasMany));
		$this->assertIsA($this->KnowledgebaseArticle->KnowledgebaseArticlesKnowledgebaseCategory, 'Model');
		
		$this->assertTrue($this->KnowledgebaseArticle->Behaviors->attached('Containable'));
		$this->assertTrue($this->KnowledgebaseArticle->Behaviors->attached('Sluggable'));

	}
	
	/**
	 * Test Validation
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testValidation () {
		
		$this->KnowledgebaseArticle->set(array(
			'KnowledgebaseArticle' => array(
				'title' => ''
			)
		));
		$invalid_fields = $this->KnowledgebaseArticle->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 1, 'There should be 1 invalid field');
		
		$over_255 = '';
		for ($i=1; $i <= 256; $i++) {
			$over_255 .= 'a';
		}
		$this->KnowledgebaseArticle->set(array(
			'KnowledgebaseArticle' => array(
				'title' => $over_255
			)
		));
		$invalid_fields = $this->KnowledgebaseArticle->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 1, 'There should be 1 invalid field');
		
		$this->KnowledgebaseArticle->set(array(
			'KnowledgebaseArticle' => array(
				'title' => 'Valid Title'
			)
		));
		$invalid_fields = $this->KnowledgebaseArticle->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 0, 'All fields should be valid');
		
		$this->KnowledgebaseArticle->set(array(
			'KnowledgebaseArticle' => array(
				'body' => ''
			)
		));
		$invalid_fields = $this->KnowledgebaseArticle->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 1, 'There should be 1 invalid field');
		
		$this->KnowledgebaseArticle->set(array(
			'KnowledgebaseArticle' => array(
				'body' => 'Valid body'
			)
		));
		$invalid_fields = $this->KnowledgebaseArticle->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 0, 'All fields should be valid');
		
	}
	
	/**
	 * Test Sluggable behavior config
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testSluggableBehaviorConfig () {
		
		$saved_portal = $this->KnowledgebaseArticle->save(array(
			'KnowledgebaseArticle' => array(
				'title' => 'Some Knowledgebase Article Title'
			)
		));
		
		$this->assertEqual($saved_portal['KnowledgebaseArticle']['slug'], 'some-knowledgebase-article-title', 'The "slug" column is not being properly populated with a slug');
		
	}
	
	/*
	 * Test search
	 * 
	 * @author	Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function testSearch () {
		
		// Searching all articles in Portal 1 for "non-existent-query"
		$result = $this->KnowledgebaseArticle->search(
			1,
			'non-existent-query'
		);
		
		$this->assertTrue(empty($result), 'No results should be returned');
		
		// Searching all articles in Portal 1 for "unique content"
		$result = $this->KnowledgebaseArticle->search(
			1,
			'unique content'
		);
		
		$this->assertEqual(Set::extract($result, '/KnowledgebaseArticle/id'), array(3), 'Article 3 should be returned');
		
		// Searching articles inside Category ID 2 existing in Portal 1 for "unique content"
		$result = $this->KnowledgebaseArticle->search(
			1,
			'unique content',
			array('category_ids' => array(2))
		);
		
		$this->assertTrue(empty($result), 'No results should be returned');
		
		// Searching articles inside Category ID 1 existing in Portal 1 for "unique content"
		$result = $this->KnowledgebaseArticle->search(
			1,
			'unique content',
			array('category_ids' => array(1))
		);
		
		$this->assertEqual(Set::extract($result, '/KnowledgebaseArticle/id'), array(3), 'Article 3 should be returned');
		
	}
	
}

?>