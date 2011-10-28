<?php

/**
 * KnowledgebasePortal Model Test Case
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.cases.models
 * @since       0.1
 * @see         KnowledgebasePortal
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebasePortalTestCase extends CakeTestCase {

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
		
		$this->KnowledgebasePortal =& ClassRegistry::init('Knowledgebase.KnowledgebasePortal');
		
	}

	/**
	 * endTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function endTest () {
		
		unset($this->KnowledgebasePortal);
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

		$this->assertIsA($this->KnowledgebasePortal, 'Model');
		$this->assertTrue(array_key_exists('KnowledgebaseArticle', $this->KnowledgebasePortal->hasMany));
		$this->assertIsA($this->KnowledgebasePortal->KnowledgebaseArticle, 'Model');
		$this->assertTrue(array_key_exists('KnowledgebaseCategory', $this->KnowledgebasePortal->hasMany));
		$this->assertIsA($this->KnowledgebasePortal->KnowledgebaseCategory, 'Model');
		
		$this->assertTrue($this->KnowledgebasePortal->Behaviors->attached('Containable'));
		$this->assertTrue($this->KnowledgebasePortal->Behaviors->attached('Sluggable'));

	}
	
	/**
	 * Test Validation
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testValidation () {
		
		$this->KnowledgebasePortal->set(array(
			'KnowledgebasePortal' => array(
				'title' => ''
			)
		));
		$invalid_fields = $this->KnowledgebasePortal->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 1, 'There should be 1 invalid field');
		
		$this->KnowledgebasePortal->set(array(
			'KnowledgebasePortal' => array(
				'title' => 'Over 50 Over 50 Over 50 Over 50 Over 50 Over 50 Over 50'
			)
		));
		$invalid_fields = $this->KnowledgebasePortal->invalidFields();
		
		$this->assertEqual(count($invalid_fields), 1, 'There should be 1 invalid field');
		
		$this->KnowledgebasePortal->set(array(
			'KnowledgebasePortal' => array(
				'title' => 'Valid Title'
			)
		));
		$invalid_fields = $this->KnowledgebasePortal->invalidFields();
		
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
		
		$saved_portal = $this->KnowledgebasePortal->save(array(
			'KnowledgebasePortal' => array(
				'title' => 'Some Knowledgebase Portal Name'
			)
		));
		
		$this->assertEqual($saved_portal['KnowledgebasePortal']['slug'], 'some-knowledgebase-portal-name', 'The "slug" column is not being properly populated with a slug');
		
	}
	
}

?>