<?php
/**
 * KnowledgebaseCategories controller
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.controllers
 * @since       0.1
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseCategoriesController extends KnowledgebaseAppController {
	
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
		
		$categories = $this->KnowledgebasePortal->KnowledgebaseCategory->find('all', array(
			'conditions' => array(
				'KnowledgebaseCategory.knowledgebase_portal_id' => $portal['KnowledgebasePortal']['id']
			),
			'order' => array(
				'KnowledgebaseCategory.title' => 'asc'
			),
			'contain' => false
		));
		
		$this->set('categories', $categories);
		
		$this->set('title_for_layout', 'Categories');
		
	}
	
	/**
	 * admin delete
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	int		Category ID
	 * @return	void
	 */
	public function admin_delete ($category_id=0) {
		
		if ($this->KnowledgebasePortal->KnowledgebaseCategory->delete($category_id)) {
			$this->Session->setFlash('Category deleted');
		} else {
			$this->Session->setFlash('Category could not be deleted');
		}
		
		return $this->redirect($this->referer());
		
	}
	
	/**
	 * admin add/edit
	 *
	 * @author  Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	string	'add' or 'edit'
	 * @param	int		Category ID
	 * @return	bool
	 */
	private function _adminAddEdit ($add_edit='add', $category_id=0) {
		
		$this->autoRender = false;
		
		if (empty($this->portal)) {
			$this->redirect($this->referer());
			return false;
		}
		
		if (!empty($this->data)) {
			if (!$this->KnowledgebasePortal->KnowledgebaseCategory->save($this->data)) {
				$this->Session->setFlash('Category could not be saved. Please correct any errors below.');
			} else {
				$this->Session->setFlash('Category saved');
				$this->redirect(array('action' => 'index', $this->data['KnowledgebaseCategory']['knowledgebase_portal_id']));
				return true;
			}
		}
		
		if ($add_edit == 'edit') {
			
			if (empty($category_id)) {
				$this->redirect($this->referer());
				return false;
			}
			
			$category = $this->KnowledgebasePortal->KnowledgebaseCategory->find('first', array(
				'conditions' => array(
					'KnowledgebaseCategory.id' => $category_id
				),
				'contain' => false
			));
			
			if (empty($category)) {
				$this->redirect($this->referer());
				return false;
			}
			
			if (empty($this->data)) {
				$this->data = $category;
			}
			
			$portal = $this->KnowledgebasePortal->find('first', array(
				'conditions' => array(
					'KnowledgebasePortal.id' => $this->data['KnowledgebaseCategory']['knowledgebase_portal_id']
				),
				'contain' => false
			));
			
			if (empty($portal)) {
				$this->redirect($this->referer());
				return false;
			}
			
			$this->set('portal', $portal);
			
		}
		
		if (empty($this->data)) {
			$this->data['KnowledgebaseCategory']['knowledgebase_portal_id'] = $this->portal['KnowledgebasePortal']['id'];
		}
		
		$this->set('knowledgebase_portal_options', $this->KnowledgebasePortal->find('list', array(
			'fields' => array('id', 'title'),
			'order' => array(
				'KnowledgebasePortal.title' => 'asc'
			),
			'contain' => false
		)));
		
		$this->set('title_for_layout', ucfirst($add_edit) . ' Category');
		
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
	 * @param	int		Category ID
	 * @return	void
	 */
	public function admin_edit ($category_id=0) {
		
		$this->_adminAddEdit('edit', $category_id);
		
	}
	
}
?>