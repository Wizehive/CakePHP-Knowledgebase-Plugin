<?php

App::import('Controller', 'Knowledgebase.KnowledgebaseAppController');
 
class TestKnowledgebaseAppController extends KnowledgebaseAppController {
    var $name = 'KnowledgebaseApp';
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
 * KnowledgebaseAppController Test
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests
 * @uses		KnowledgebaseAppController
 * @since       0.1
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebasePortalsAppTest extends CakeTestCase {

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
	 * @return void
	 */
	public function __construct() {
		
		$fixtures = array();
		$folder = new Folder(TESTS . 'fixtures');
		$contents = $folder->read();

		if (!empty($contents[1])) {
			foreach($contents[1] as $file) {
				$fixtures[] = 'app.' . str_replace('_fixture.php', '', $file);
			}
		}

		$this->fixtures = array_merge($fixtures, $this->fixtures);

		parent::__construct();

	}
	
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
		
	    $this->KnowledgebaseApp = new TestKnowledgebaseAppController();
	    $this->KnowledgebaseApp->constructClasses();
	    $this->KnowledgebaseApp->Component->initialize($this->KnowledgebaseApp);
		
	}

	/**
	 * endTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function endTest() {
		
		$this->KnowledgebaseApp->Session->destroy();
	    unset($this->KnowledgebaseApp);
	    ClassRegistry::flush();
		
	}
	
	/**
	 * Test beforeFilter layout declaration
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testBeforeFilterLayoutDeclaration () {
		
		$this->KnowledgebaseApp->params = Router::parse('/knowledgebase/knowledgebase_portals/view/portal_slug:portal-1');
	    $this->KnowledgebaseApp->beforeFilter();
	    
	    $this->assertEqual($this->KnowledgebaseApp->layout, 'knowledgebase', 'The layout should be set to "knowledgebase"');
		
	}
	
	/**
	 * Test beforeFilter with valid portal slug
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testBeforeFilterWithValidPortalSlug () {
		
		// Should work as normal parameter
		
		$this->KnowledgebaseApp->params = array(
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
		$this->KnowledgebaseApp->beforeFilter();
	    
	    $this->assertEqual($this->KnowledgebaseApp->redirectUrl, null, 'The page should not redirect');
	    $this->assertTrue(!isset($this->KnowledgebaseApp->stopped), 'The page should not stop');
	    
	    $vars = $this->KnowledgebaseApp->viewVars;
	    
	    $this->assertEqual($vars['portal']['KnowledgebasePortal']['id'], 1, 'The Portal ID should be 1');
	    $this->assertEqual(count($vars['portal']['KnowledgebaseCategory']), 2, 'There should be 2 categories');
	    
	    // Should also work as named parameter
	    
	    $vars = $this->KnowledgebaseApp->viewVars = array();
	    
	    $this->KnowledgebaseApp->params = array(
			'named' => array(
	    		'portal_slug' => 'portal-1'
	    	),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_portals',
			'action' => 'view',
			'url' => array(
				'ext' => 'html'
			)
		);
		$this->KnowledgebaseApp->beforeFilter();
	    
	    $this->assertEqual($this->KnowledgebaseApp->redirectUrl, null, 'The page should not redirect');
	    $this->assertTrue(!isset($this->KnowledgebaseApp->stopped), 'The page should not stop');
	    
	    $vars = $this->KnowledgebaseApp->viewVars;
	    
	    $this->assertEqual($vars['portal']['KnowledgebasePortal']['id'], 1, 'The Portal ID should be 1');
	    $this->assertEqual(count($vars['portal']['KnowledgebaseCategory']), 2, 'There should be 2 categories');
		
	}

}

?>