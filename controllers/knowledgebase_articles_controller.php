<?php
/**
 * KnowledgebaseArticles controller
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.controllers
 * @since       0.1
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseArticlesController extends KnowledgebaseAppController {
	
	/*
	 * @var	array
	 */
	public $uses = array();
	
	/*
	 * @var	array
	 */
	public $helpers = array();
	
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
	 * @param	int		Portal ID
	 * @return	void
	 */
	public function admin_index ($portal_id=0) {
		
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
		
		$this->set('portal', $portal);
		
		$articles = $this->KnowledgebasePortal->KnowledgebaseArticle->find('all', array(
			'conditions' => array(
				'KnowledgebaseArticle.knowledgebase_portal_id' => $portal['KnowledgebasePortal']['id']
			),
			'order' => array(
				'KnowledgebaseArticle.created' => 'asc'
			),
			'contain' => false
		));
		
		$this->set('articles', $articles);
		
		$this->set('title_for_layout', $portal['KnowledgebasePortal']['title'] . ': Articles');
		
	}
	
	/**
	 * admin delete
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	int		Article ID
	 * @return	void
	 */
	public function admin_delete ($article_id=0) {
		
		if ($this->KnowledgebasePortal->KnowledgebaseArticle->delete($article_id)) {
			$this->Session->setFlash('Article deleted');
		} else {
			$this->Session->setFlash('Article could not be deleted');
		}
		
		return $this->redirect($this->referer());
		
	}
	
	/**
	 * admin add/edit
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	string	'add' or 'edit'
	 * @param	int		Article ID
	 * @return	bool
	 */
	private function _adminAddEdit ($add_edit='add', $article_id=0) {
		
		$this->autoRender = false;
		
		if (empty($this->portal)) {
			$this->redirect($this->referer());
			return false;
		}
		
		$category_list = $this->KnowledgebasePortal->KnowledgebaseCategory->find('list', array(
			'conditions' => array(
				'KnowledgebaseCategory.knowledgebase_portal_id' => $this->portal['KnowledgebasePortal']['id']
			),
			'fields' => array('id', 'title'),
			'order' => array(
				'KnowledgebaseCategory.title' => 'asc'
			),
			'contain' => false
		));
		
		$this->set('category_list', $category_list);
		
		if ($add_edit == 'edit') {
			
			if (empty($article_id)) {
				$this->redirect($this->referer());
				return false;
			}
			
			$article = $this->KnowledgebasePortal->KnowledgebaseArticle->find('first', array(
				'conditions' => array(
					'KnowledgebaseArticle.id' => $article_id
				),
				'contain' => array(
					'KnowledgebaseArticlesKnowledgebaseCategory'
				)
			));
			
			if (empty($article)) {
				$this->redirect($this->referer());
				return false;
			}
			
			$this->set('article', $article);
			
			$portal = $this->KnowledgebasePortal->find('first', array(
				'conditions' => array(
					'KnowledgebasePortal.id' => (!empty($this->data['KnowledgebaseArticle']['knowledgebase_portal_id']) ? $this->data['KnowledgebaseArticle']['knowledgebase_portal_id'] : $article['KnowledgebaseArticle']['knowledgebase_portal_id'])
				),
				'contain' => false
			));
			
			if (empty($portal)) {
				$this->redirect($this->referer());
				return false;
			}
			
			$this->set('portal', $portal);
			
		}
		
		if (!empty($this->data)) {
			
			//TODO(anthony@wizehive.com): This complex logic can probably be re-thought or moved to the model
			$this->Session->setFlash('Article could not be saved. Please correct any errors below.');
			
			$this->KnowledgebasePortal->KnowledgebaseArticle->KnowledgebaseArticlesKnowledgebaseCategory->begin();
			$join_result = $this->KnowledgebasePortal->KnowledgebaseArticle->KnowledgebaseArticlesKnowledgebaseCategory->removeDeletedJoins(
				!empty($article['KnowledgebaseArticlesKnowledgebaseCategory']) ? $article['KnowledgebaseArticlesKnowledgebaseCategory'] : array(),
				!empty($this->data['KnowledgebaseArticlesKnowledgebaseCategory']) ? $this->data['KnowledgebaseArticlesKnowledgebaseCategory'] : array()
			);
			
			$this->data['KnowledgebaseArticlesKnowledgebaseCategory'] = $join_result['new_joins'];
			if (empty($this->data['KnowledgebaseArticlesKnowledgebaseCategory'])) {
				unset($this->data['KnowledgebaseArticlesKnowledgebaseCategory']);
			}
			
			if (!$join_result['success']) {
				$this->KnowledgebasePortal->KnowledgebaseArticle->KnowledgebaseArticlesKnowledgebaseCategory->rollback();
			}
			
			if (!$join_result['success'] || !$this->KnowledgebasePortal->KnowledgebaseArticle->saveAll($this->data, array('validate' => 'first', 'atomic' => false))) {
				$this->KnowledgebasePortal->KnowledgebaseArticle->KnowledgebaseArticlesKnowledgebaseCategory->rollback();
				$this->Session->setFlash('Article could not be saved. Please correct any errors below.');
			} else {
				$this->KnowledgebasePortal->KnowledgebaseArticle->KnowledgebaseArticlesKnowledgebaseCategory->commit();
				$this->Session->setFlash('Article saved');
				$this->redirect(array('action' => 'index', $this->data['KnowledgebaseArticle']['knowledgebase_portal_id']));
				return true;
			}
			
		}
		
		if ($add_edit == 'edit' && empty($this->data)) {
			$this->data = $article;
		}
		
		if (empty($this->data)) {
			$this->data['KnowledgebaseArticle']['knowledgebase_portal_id'] = $this->portal['KnowledgebasePortal']['id'];
		}
		
		$this->helpers = array_merge(
			!empty($this->helpers) ? $this->helpers : array(),
			array('CKEditor.CKEditor')
		);
		
		$this->set('knowledgebase_portal_options', $this->KnowledgebasePortal->find('list', array(
			'fields' => array('id', 'title'),
			'order' => array(
				'KnowledgebasePortal.title' => 'asc'
			),
			'contain' => false
		)));
		
		$this->set('title_for_layout', ucfirst($add_edit) . ' Article');
		
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
	public function admin_edit ($article_id=0) {
		
		$this->_adminAddEdit('edit', $article_id);
		
	}
	
	/**
	 * index
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function index () {
		
		if (empty($this->portal)) {
			return $this->redirect($this->referer());
		}
		
		if (!empty($this->params['named']['category'])) {
			$category_id = $this->KnowledgebasePortal->KnowledgebaseCategory->field('id', array('slug' => trim($this->params['named']['category'])));
			if (empty($category_id)) {
				return $this->redirect($this->referer());
			}
		}
		
		$this->helpers = array_merge(
			$this->helpers,
			array('Knowledgebase.KnowledgebaseSearch')
		);
		
		$articles = $this->KnowledgebasePortal->KnowledgebaseArticle->search(
			$this->portal['KnowledgebasePortal']['id'], 
			!empty($this->params['url']['query']) ? $this->params['url']['query'] : '',
			array(
				'category_ids' => !empty($category_id) ? array($category_id) : array()
			)
		);
		
		$this->layout = 'ajax';
		
		$this->set('articles', $articles);
		
		$this->set('title_for_layout', $this->portal['KnowledgebasePortal']['title'] . ': Search: ' . $this->params['url']['query']);
		
	}

	/**
	 * view
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @return	void
	 */
	public function view () {
		
		if (empty($this->portal) || empty($this->params['article_slug'])) {
			return $this->redirect($this->referer());
		}
		
		$article = $this->KnowledgebasePortal->KnowledgebaseArticle->find('first', array(
			'conditions' => array(
				'KnowledgebaseArticle.knowledgebase_portal_id' => $this->portal['KnowledgebasePortal']['id'],
				'KnowledgebaseArticle.slug' => trim($this->params['article_slug'])
			),
			'contain' => array(
				'KnowledgebaseArticlesKnowledgebaseCategory' => array(
					'KnowledgebaseCategory'
				)
			)
		));
		
		if (empty($article)) {
			return $this->redirect($this->referer());
		}
		
		$this->KnowledgebasePortal->KnowledgebaseArticle->id = $article['KnowledgebaseArticle']['id'];
		$this->KnowledgebasePortal->KnowledgebaseArticle->saveField('view_count', ($article['KnowledgebaseArticle']['view_count']+1));
		
		$this->set('article', $article);
		
		$this->set('title_for_layout', $this->portal['KnowledgebasePortal']['title'] . ': ' . $article['KnowledgebaseArticle']['title']);
		
	}
	
}
?>