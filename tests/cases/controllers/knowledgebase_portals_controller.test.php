<?php

App::import('Controller', 'Knowledgebase.KnowledgebasePortals');
 
class TestKnowledgebasePortalsController extends KnowledgebasePortalsController {
    var $name = 'KnowledgebasePortals';
    var $autoRender = false;
    var $redirectUrl = null;
    var $renderedAction = null;
    var $data = array();
    var $params = array();
    function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
        if ($exit) {
        	$this->_stop();
        }
    }
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
    function _stop($status = 0) {
        $this->stopped = $status;
    }
}

/**
 * KnowledgebasePortalsController Test
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.controller
 * @uses		KnowledgebasePortalsController
 * @since       0.1
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebasePortalsControllerTest extends CakeTestCase {

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
	 * Runs before all tests
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function start () {
		
		parent::start();
		
	}
	
	/**
	 * startTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function startTest() {
		
	    $this->KnowledgebasePortals = new TestKnowledgebasePortalsController();
	    $this->KnowledgebasePortals->constructClasses();
	    $this->KnowledgebasePortals->Component->initialize($this->KnowledgebasePortals);
		
	}

	/**
	 * endTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function endTest() {
		
		$this->KnowledgebasePortals->Session->destroy();
	    unset($this->KnowledgebasePortals);
	    ClassRegistry::flush();
		
	}
	
	/**
	 * Test view with invalid parameter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testViewWithInvalidParameter () {
		
		$this->KnowledgebasePortals->params = array(
			'portal_slug' => 'non-existent-portal',
			'named' => array(),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_portals',
			'action' => 'view',
			'url' => array(
				'ext' => 'html'
			)
		);
	    $this->KnowledgebasePortals->beforeFilter();
	    $this->KnowledgebasePortals->Component->startup($this->KnowledgebasePortals);
	    $this->KnowledgebasePortals->view();
	    
	    $this->assertEqual($this->KnowledgebasePortals->redirectUrl, '/', 'The page should have redirected');
	    $this->assertTrue(isset($this->KnowledgebasePortals->stopped), 'The page should have stopped');
		
	}
	
	/**
	 * Test view with valid parameter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testViewWithValidParameter () {
		
		$this->KnowledgebasePortals->params = array(
			'portal_slug' => 'portal-1',
			'named' => array(),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_portals',
			'action' => 'view',
			'url' => array(
				'ext' => 'html'
			)
		);
	    $this->KnowledgebasePortals->beforeFilter();
	    $this->KnowledgebasePortals->Component->startup($this->KnowledgebasePortals);
	    $this->KnowledgebasePortals->view();
	    
	    $this->assertEqual($this->KnowledgebasePortals->redirectUrl, null, 'The page should not redirect');
	    $this->assertTrue(!isset($this->KnowledgebasePortals->stopped), 'The page should not stop');
	    
	    $vars = $this->KnowledgebasePortals->viewVars;
	    
	    $this->assertEqual($vars['title_for_layout'], 'Portal 1', 'The title should be Portal 1');
	    $this->assertEqual(count($vars['articles']), 3, 'There should be 3 articles');
		
	}
	
	/**
	 * Test view with invalid category
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testViewWithInvalidCategory () {
		
		$this->KnowledgebasePortals->params = array(
			'portal_slug' => 'portal-1',
			'named' => array(
				'category' => 'invalid-category'
			),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_portals',
			'action' => 'view',
			'url' => array(
				'ext' => 'html'
			)
		);
	    $this->KnowledgebasePortals->beforeFilter();
	    $this->KnowledgebasePortals->Component->startup($this->KnowledgebasePortals);
	    $this->KnowledgebasePortals->view();
	    
	    $this->assertEqual($this->KnowledgebasePortals->redirectUrl, '/', 'The page should have redirected');
	    $this->assertTrue(isset($this->KnowledgebasePortals->stopped), 'The page should have stopped');
		
	}
	
	/**
	 * Test view with valid category
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testViewWithValidCategory () {
		
		$this->KnowledgebasePortals->params = array(
			'portal_slug' => 'portal-1',
			'named' => array(
				'category' => 'second-category'
			),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_portals',
			'action' => 'view',
			'url' => array(
				'ext' => 'html'
			)
		);
	    $this->KnowledgebasePortals->beforeFilter();
	    $this->KnowledgebasePortals->Component->startup($this->KnowledgebasePortals);
	    $this->KnowledgebasePortals->view();
	    
	    $this->assertEqual($this->KnowledgebasePortals->redirectUrl, null, 'The page should not redirect');
	    $this->assertTrue(!isset($this->KnowledgebasePortals->stopped), 'The page should not stop');
	    
	    $vars = $this->KnowledgebasePortals->viewVars;
	    
	    $this->assertEqual($vars['title_for_layout'], 'Portal 1: Second Category', 'The title should be Portal 1: Second Category');
	    $this->assertEqual(count($vars['articles']), 1, 'There should be 1 articles');
		
	}

}

?>