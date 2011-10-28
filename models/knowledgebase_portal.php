<?php
/**
 * KnowledgebasePortal Model
 *
 * PHP version 5.3
 * CakePHP version 1.3
 *
 * @package    	knowledgebase
 * @subpackage 	knowledgebase.models
 */
class KnowledgebasePortal extends KnowledgebaseAppModel {

	/**
	 * @var string
	 */
	public $name = 'KnowledgebasePortal';
	
	/*
	 * @var	array
	 */
	public $actsAs = array(
		'Containable',
		'Utils.Sluggable' => array(
			'label' => 'title',
			'length' => 50,
			'separator' => '-'
		)
	);
	
	/*
	 * @var	array
	 */
	public $hasMany = array(
		'KnowledgebaseArticle' => array(
			'className' => 'Knowledgebase.KnowledgebaseArticle',
			'foreignKey' => 'knowledgebase_portal_id',
			'order' => array(
				'KnowledgebaseArticle.created' => 'desc'
			),
			'limit' => 20,
			'dependent' => false
		),
		'KnowledgebaseCategory' => array(
			'className' => 'Knowledgebase.KnowledgebaseCategory',
			'foreignKey' => 'knowledgebase_portal_id',
			'order' => array(
				'KnowledgebaseCategory.title' => 'asc'
			),
			'limit' => 20,
			'dependent' => false
		)
	);
	
	/*
	 * Validation
	 * 
	 * @var	array
	 */
	public $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a portal name',
				'allowEmpty' => false,
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'Please enter a portal name no longer than 50 characters',
				'allowEmpty' => false
			)
		)
	);
	
}
?>