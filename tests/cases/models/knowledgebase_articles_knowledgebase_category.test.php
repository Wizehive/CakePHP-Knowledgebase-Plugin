<?php

/**
 * KnowledgebaseArticlesKnowledgebaseCategory Model Test Case
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.cases.models
 * @since       0.1
 * @see         KnowledgebaseArticlesKnowledgebaseCategory
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseArticlesKnowledgebaseCategoryTestCase extends CakeTestCase {

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

	}
	
	/**
	 * startTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function startTest () {
		
		$this->KnowledgebaseArticlesKnowledgebaseCategory =& ClassRegistry::init('Knowledgebase.KnowledgebaseArticlesKnowledgebaseCategory');
		
	}

	/**
	 * endTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function endTest () {
		
		unset($this->KnowledgebaseArticlesKnowledgebaseCategory);
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

		$this->assertIsA($this->KnowledgebaseArticlesKnowledgebaseCategory, 'Model');
		$this->assertTrue(array_key_exists('KnowledgebaseArticle', $this->KnowledgebaseArticlesKnowledgebaseCategory->belongsTo));
		$this->assertIsA($this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseArticle, 'Model');
		$this->assertTrue(array_key_exists('KnowledgebaseCategory', $this->KnowledgebaseArticlesKnowledgebaseCategory->belongsTo));
		$this->assertIsA($this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory, 'Model');
		
		$this->assertTrue($this->KnowledgebaseArticlesKnowledgebaseCategory->Behaviors->attached('Containable'));

	}
	
	/**
	 * Test counterCache
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testCounterCache () {
		
		$this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory->id = 2;
		$article_count = $this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory->field('article_count');
		
		$this->assertEqual($article_count, 1, 'The article count should be 1');
		
		$this->KnowledgebaseArticlesKnowledgebaseCategory->create(false);
		$this->KnowledgebaseArticlesKnowledgebaseCategory->save(array(
			'KnowledgebaseArticlesKnowledgebaseCategory' => array(
				'knowledgebase_article_id' => 1,
				'knowledgebase_category_id' => 2
			)
		));
		
		$this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory->id = 2;
		$article_count = $this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory->field('article_count');
		
		$this->assertEqual($article_count, 2, 'The article count should be 2');
		
		// Updating the previous save
		$this->KnowledgebaseArticlesKnowledgebaseCategory->save(array(
			'KnowledgebaseArticlesKnowledgebaseCategory' => array(
				'knowledgebase_article_id' => 3,
				'knowledgebase_category_id' => 2
			)
		));
		
		$this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory->id = 2;
		$article_count = $this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory->field('article_count');
		
		$this->assertEqual($article_count, 2, 'The article count should be 2');
		
		$this->KnowledgebaseArticlesKnowledgebaseCategory->delete($this->KnowledgebaseArticlesKnowledgebaseCategory->id);
		
		$this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory->id = 2;
		$article_count = $this->KnowledgebaseArticlesKnowledgebaseCategory->KnowledgebaseCategory->field('article_count');
		
		$this->assertEqual($article_count, 1, 'The article count should be 1');
		
	}
	
}

?>