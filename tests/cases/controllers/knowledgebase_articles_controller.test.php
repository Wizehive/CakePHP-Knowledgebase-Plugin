<?php

App::import('Controller', 'Knowledgebase.KnowledgebaseArticles');
 
class TestKnowledgebaseArticlesController extends KnowledgebaseArticlesController {
    var $name = 'KnowledgebaseArticles';
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
 * KnowledgebaseArticlesController Test
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.controller
 * @uses		KnowledgebaseArticlesController
 * @since       0.1
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseArticlesControllerTest extends CakeTestCase {

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
	public function startTest() {
		
	    $this->KnowledgebaseArticles = new TestKnowledgebaseArticlesController();
	    $this->KnowledgebaseArticles->constructClasses();
	    $this->KnowledgebaseArticles->Component->initialize($this->KnowledgebaseArticles);
		
	}

	/**
	 * endTest
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function endTest() {
		
		$this->KnowledgebaseArticles->Session->destroy();
	    unset($this->KnowledgebaseArticles);
	    ClassRegistry::flush();
		
	}
	
	/**
	 * Test index with invalid portal parameter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testIndexWithInvalidPortalParameter () {
		
		$this->KnowledgebaseArticles->params = array(
			'portal_slug' => 'non-existent-portal',
			'named' => array(),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_articles',
			'action' => 'index',
			'url' => array(
				'ext' => 'html',
				'query' => 'unique'
			)
		);
	    $this->KnowledgebaseArticles->beforeFilter();
	    $this->KnowledgebaseArticles->Component->startup($this->KnowledgebaseArticles);
	    $this->KnowledgebaseArticles->index();
	    
	    $this->assertTrue(!empty($this->KnowledgebaseArticles->redirectUrl), 'The page should have redirected');
	    $this->assertTrue(isset($this->KnowledgebaseArticles->stopped), 'The page should have stopped');
		
	}
	
	/**
	 * Test index with invalid category parameter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testIndexWithInvalidCategoryParameter () {
		
		$this->KnowledgebaseArticles->params = array(
			'portal_slug' => 'portal-1',
			'named' => array(
				'category' => 'non-existent-category'
			),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_articles',
			'action' => 'index',
			'url' => array(
				'ext' => 'html',
				'query' => 'unique'
			)
		);
	    $this->KnowledgebaseArticles->beforeFilter();
	    $this->KnowledgebaseArticles->Component->startup($this->KnowledgebaseArticles);
	    $this->KnowledgebaseArticles->index();
	    
	    $this->assertTrue(!empty($this->KnowledgebaseArticles->redirectUrl), 'The page should have redirected');
	    $this->assertTrue(isset($this->KnowledgebaseArticles->stopped), 'The page should have stopped');
		
	}
	
	/**
	 * Test index with valid portal parameter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testIndexWithValidPortalParameter () {
		
		$this->KnowledgebaseArticles->params = array(
			'portal_slug' => 'portal-1',
			'named' => array(),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_articles',
			'action' => 'index',
			'url' => array(
				'ext' => 'html',
				'query' => 'unique'
			)
		);
	    $this->KnowledgebaseArticles->beforeFilter();
	    $this->KnowledgebaseArticles->Component->startup($this->KnowledgebaseArticles);
	    $this->KnowledgebaseArticles->index();
	    
	    $this->assertEqual($this->KnowledgebaseArticles->redirectUrl, null, 'The page should not redirect');
	    $this->assertTrue(!isset($this->KnowledgebaseArticles->stopped), 'The page should not stop');
	    
	    $this->assertEqual($this->KnowledgebaseArticles->layout, 'ajax', 'The layout should be "ajax"');
	    
	    $vars = $this->KnowledgebaseArticles->viewVars;
	    
	    $this->assertEqual($vars['title_for_layout'], 'Portal 1: Search: unique', 'The title should be Portal 1: Search: unique');
	    $this->assertEqual(count($vars['articles']), 1, '1 Article should be found');
	    
	    $this->assertTrue(in_array('Knowledgebase.KnowledgebaseSearch', $this->KnowledgebaseArticles->helpers), 'The KnowledgebaseSearch helper should be included in the helpers array');
	    
	}
	
	/**
	 * Test index with valid category parameter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testIndexWithValidCategoryParameter () {
		
		$this->KnowledgebaseArticles->params = array(
			'portal_slug' => 'portal-1',
			'named' => array(
				'category' => 'first-category'
			),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_articles',
			'action' => 'index',
			'url' => array(
				'ext' => 'html',
				'query' => 'unique'
			)
		);
	    $this->KnowledgebaseArticles->beforeFilter();
	    $this->KnowledgebaseArticles->Component->startup($this->KnowledgebaseArticles);
	    $this->KnowledgebaseArticles->index();
	    
	    $this->assertEqual($this->KnowledgebaseArticles->redirectUrl, null, 'The page should not redirect');
	    $this->assertTrue(!isset($this->KnowledgebaseArticles->stopped), 'The page should not stop');
	    
	    $this->assertEqual($this->KnowledgebaseArticles->layout, 'ajax', 'The layout should be "ajax"');
	    
	    $vars = $this->KnowledgebaseArticles->viewVars;
	    
	    $this->assertEqual($vars['title_for_layout'], 'Portal 1: Search: unique', 'The title should be Portal 1: Search: unique');
	    $this->assertEqual(count($vars['articles']), 1, '1 Article should be found');
	    
	    $this->assertTrue(in_array('Knowledgebase.KnowledgebaseSearch', $this->KnowledgebaseArticles->helpers), 'The KnowledgebaseSearch helper should be included in the helpers array');
	    
	}
	
	/**
	 * Test view with invalid parameter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testViewWithInvalidParameter () {
		
		$this->KnowledgebaseArticles->params = array(
			'portal_slug' => 'non-existent-portal',
			'article_slug' => 'non-existent-article',
			'named' => array(),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_articles',
			'action' => 'view',
			'url' => array(
				'ext' => 'html'
			)
		);
	    $this->KnowledgebaseArticles->beforeFilter();
	    $this->KnowledgebaseArticles->Component->startup($this->KnowledgebaseArticles);
	    $this->KnowledgebaseArticles->view();
	    
	    $this->assertTrue(!empty($this->KnowledgebaseArticles->redirectUrl), 'The page should have redirected');
	    $this->assertTrue(isset($this->KnowledgebaseArticles->stopped), 'The page should have stopped');
		
	}
	
	/**
	 * Test view with valid parameter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return  void
	 */
	public function testViewWithValidParameter () {
		
		$this->KnowledgebaseArticles->params = array(
			'portal_slug' => 'portal-1',
			'article_slug' => 'first-article',
			'named' => array(),
			'pass' => array(),
			'plugin' => 'knowledgebase',
			'controller' => 'knowledgebase_articles',
			'action' => 'view',
			'url' => array(
				'ext' => 'html'
			)
		);
	    $this->KnowledgebaseArticles->beforeFilter();
	    $this->KnowledgebaseArticles->Component->startup($this->KnowledgebaseArticles);
	    $this->KnowledgebaseArticles->view();
	    
	    $this->assertEqual($this->KnowledgebaseArticles->redirectUrl, null, 'The page should not redirect');
	    $this->assertTrue(!isset($this->KnowledgebaseArticles->stopped), 'The page should not stop');
	    
	    $vars = $this->KnowledgebaseArticles->viewVars;
	    
	    $this->assertEqual($vars['title_for_layout'], 'Portal 1: First Article', 'The title should be Portal 1: First Article');
	    $this->assertEqual($vars['article']['KnowledgebaseArticle']['id'], 1, 'The Article ID should be 1');
	    $this->assertEqual(count($vars['article']['KnowledgebaseArticlesKnowledgebaseCategory']), 1, 'There should be 1 category');
	    
	    $view_count = $this->KnowledgebaseArticles->KnowledgebasePortal->KnowledgebaseArticle->field('view_count', array('slug' => 'first-article'));
	    
	    $this->assertEqual($view_count, 1, 'The view count should have been incremented to 1');
		
	}

}

?>