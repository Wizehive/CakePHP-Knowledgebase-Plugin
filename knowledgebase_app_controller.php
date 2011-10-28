<?php
/**
 * Knowledgebase App Controller File
 *
 * PHP version 5.3
 * CakePHP version 1.3
 *
 * @package    	knowledgebase
 * @since		0.1
 */
class KnowledgebaseAppController extends AppController {
	
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
		
		$this->KnowledgebasePortal = ClassRegistry::init('Knowledgebase.KnowledgebasePortal');
		
		if (!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$this->layout = 'knowledgebase_admin';
		} else {
			$this->layout = 'knowledgebase';
		}
		
		if (!empty($this->params['portal_slug']) || !empty($this->params['named']['portal_slug'])) {
			$portal_slug = !empty($this->params['portal_slug']) ? $this->params['portal_slug'] : $this->params['named']['portal_slug'];
			$portal = $this->KnowledgebasePortal->find('first', array(
				'conditions' => array(
					'KnowledgebasePortal.slug' => trim($portal_slug)
				),
				'contain' => array(
					'KnowledgebaseCategory'
				)
			));
			if (!empty($portal)) {
				$this->portal = $portal;
				$this->set('portal', $this->portal);
			}
		}
		
	}
	
}
?>