<?php

/**
 * KnowledgebaseCategory Model Test Case
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.cases.models
 * @since       0.1
 * @see         KnowledgebaseCategory
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseCategoryTestCase extends CakeTestCase {

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
		
		$this->KnowledgebaseCategory =& ClassRegistry::init('Knowledgebase.KnowledgebaseCategory');
		
	}

	/**
	 * endTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function endTest () {
		
		unset($this->KnowledgebaseCategory);
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

		$this->assertIsA($this->KnowledgebaseCategory, 'Model');
		$this->assertTrue(array_key_exists('KnowledgebasePortal', $this->KnowledgebaseCategory->belongsTo));
		$this->assertIsA($this->KnowledgebaseCategory->KnowledgebasePortal, 'Model');
		$this->assertTrue(array_key_exists('KnowledgebaseArticlesKnowledgebaseCategory', $this->KnowledgebaseCategory->hasMany));
		$this->assertIsA($this->KnowledgebaseCategory->KnowledgebaseArticlesKnowledgebaseCategory, 'Model');
		
		$this->assertTrue($this->KnowledgebaseCategory->Behaviors->attached('Containable'));
		$this->assertTrue($this->KnowledgebaseCategory->Behaviors->attached('Sluggable'));

	}
	
	/**
	 * Test Validation
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testValidation () {
		
		$this->KnowledgebaseCategory->set(array(
			'KnowledgebaseCategory' => array(
				'title' => ''
			)
		));
		$invalid_fields = $this->KnowledgebaseCategory->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 1, 'There should be 1 invalid field');
		
		$this->KnowledgebaseCategory->set(array(
			'KnowledgebaseCategory' => array(
				'title' => 'Over 50 Over 50 Over 50 Over 50 Over 50 Over 50 Over 50'
			)
		));
		$invalid_fields = $this->KnowledgebaseCategory->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 1, 'There should be 1 invalid field');
		
		$this->KnowledgebaseCategory->set(array(
			'KnowledgebaseCategory' => array(
				'title' => 'Valid Name'
			)
		));
		$invalid_fields = $this->KnowledgebaseCategory->invalidFields();
		
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
		
		$saved_portal = $this->KnowledgebaseCategory->save(array(
			'KnowledgebaseCategory' => array(
				'title' => 'Some Knowledgebase Category Name'
			)
		));
		
		$this->assertEqual($saved_portal['KnowledgebaseCategory']['slug'], 'some-knowledgebase-category-name', 'The "slug" column is not being properly populated with a slug');
		
	}
	
}

?>