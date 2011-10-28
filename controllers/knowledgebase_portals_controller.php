<?php
/**
 * KnowledgebasePortals controller
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.controllers
 * @since       0.1
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebasePortalsController extends KnowledgebaseAppController {
	
	/*
	 * @var	array
	 */
	public $uses = array();
	
	/**
	 * beforeFilter
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function beforeFilter () {
		
		parent::beforeFilter();
		
	}
	
	/**
	 * admin index
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function admin_index () {
		
		$portals = $this->KnowledgebasePortal->find('all', array(
			'order' => array(
				'KnowledgebasePortal.title' => 'asc'
			),
			'contain' => false
		));
		
		$this->set('portals', $portals);
		
		$this->set('title_for_layout', 'Portals');
		
	}
	
	/**
	 * admin delete
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	int		Portal ID
	 * @return	void
	 */
	public function admin_delete ($portal_id=0) {
		
		if ($this->KnowledgebasePortal->delete($portal_id)) {
			$this->Session->setFlash('Portal deleted');
		} else {
			$this->Session->setFlash('Portal could not be deleted');
		}
		
		return $this->redirect($this->referer());
		
	}
	
	/**
	 * admin add/edit
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	string	'add' or 'edit'
	 * @param	int		Portal ID
	 * @return	bool
	 */
	private function _adminAddEdit ($add_edit='add', $portal_id=0) {
		
		$this->autoRender = false;
		
		if (!empty($this->data)) {
			if (!$this->KnowledgebasePortal->save($this->data)) {
				$this->Session->setFlash('Portal could not be saved. Please correct any errors below.');
			} else {
				$this->Session->setFlash('Portal saved');
				$this->redirect(array('action' => 'index'));
				return true;
			}
		}
		
		if ($add_edit == 'edit') {
			
			if (empty($portal_id)) {
				$this->redirect($this->referer());
				return false;
			}
			
			$portal = $this->KnowledgebasePortal->find('first', array(
				'conditions' => array(
					'KnowledgebasePortal.id' => $portal_id
				),
				'contain' => false
			));
			
			if (empty($portal)) {
				$this->redirect($this->referer());
				return false;
			}
			
			if (empty($this->data)) {
				$this->data = $portal;
			}
			
		}
		
		$this->set('title_for_layout', ucfirst($add_edit) . ' Portal');
		
		$this->render('admin_add_edit');
		
	}
	
	/**
	 * admin add
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function admin_add () {
		
		$this->_adminAddEdit('add');
		
	}
	
	/**
	 * admin edit
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	int		Portal ID
	 * @return	void
	 */
	public function admin_edit ($portal_id=0) {
		
		$this->_adminAddEdit('edit', $portal_id);
		
	}

	/**
	 * view
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function view () {
		
		if (empty($this->portal)) {
			return $this->redirect('/');
		}
		
		$article_ids = array();
		
		if (!empty($this->params['named']['category'])) {
			
			$category = $this->KnowledgebasePortal->KnowledgebaseCategory->find('first', array(
				'conditions' => array(
					'KnowledgebaseCategory.slug' => trim($this->params['named']['category'])
				),
				'contain' => false
			));
			
			if (empty($category)) {
				return $this->redirect('/');
			}
			
			$this->set('category', $category);
			
			$article_ids = $this->KnowledgebasePortal->KnowledgebaseCategory->KnowledgebaseArticlesKnowledgebaseCategory->find('list', array(
				'fields' => array('knowledgebase_article_id'),
				'conditions' => array(
					'KnowledgebaseArticlesKnowledgebaseCategory.knowledgebase_category_id' => $category['KnowledgebaseCategory']['id']
				),
				'contain' => false
			));
			if (empty($article_ids)) {
				$article_ids = array('-1');
			}
			
		}
		
		$articles = $this->KnowledgebasePortal->KnowledgebaseArticle->find('all', array(
			'conditions' => array_merge(
				array('KnowledgebaseArticle.knowledgebase_portal_id' => $this->portal['KnowledgebasePortal']['id']),
				!empty($article_ids) ? array(
					'KnowledgebaseArticle.id' => $article_ids
				) : array()
			),
			'order' => array(
				'KnowledgebaseArticle.view_count' => 'desc',
				'KnowledgebaseArticle.created' => 'desc'
			),
			'limit' => empty($this->params['named']['category']) ? Configure::read('Knowledgebase.top_articles_count') : null,
			'contain' => false
		));
		
		$this->set('articles', $articles);
		
		$title = $this->portal['KnowledgebasePortal']['title'];
		if (!empty($category)) {
			$title .= ': ' . $category['KnowledgebaseCategory']['title'];
		}
		
		$this->set('title_for_layout', $title);
		
	}
	
}
?>