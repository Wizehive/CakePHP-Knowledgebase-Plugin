<?php
/**
 * KnowledgebaseCategory Model
 *
 * PHP version 5.3
 * CakePHP version 1.3
 *
 * @package    	knowledgebase
 * @subpackage 	knowledgebase.models
 */
class KnowledgebaseCategory extends KnowledgebaseAppModel {

	/**
	 * @var string
	 */
	public $name = 'KnowledgebaseCategory';
	
	/*
	 * @var	array
	 */
	public $actsAs = array(
		'Containable',
		'Utils.Sluggable' => array(
			'label' => 'title',
			'length' => 50,
			'scope' => array('KnowledgebaseCategory.knowledgebase_portal_id'),
			'separator' => '-'
		)
	);
	
	/*
	 * @var	array
	 */
	public $belongsTo = array(
		'KnowledgebasePortal' => array(
			'className' => 'Knowledgebase.KnowledgebasePortal',
			'foreignKey' => 'knowledgebase_portal_id'
		)
	);
	
	/*
	 * @var	array
	 */
	public $hasMany = array(
		'KnowledgebaseArticlesKnowledgebaseCategory' => array(
			'className' => 'Knowledgebase.KnowledgebaseArticlesKnowledgebaseCategory',
			'foreignKey' => 'knowledgebase_category_id',
			'limit' => 20,
			'dependent' => true
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
				'message' => 'Please enter a name',
				'allowEmpty' => false,
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'Please enter a name no longer than 50 characters',
				'allowEmpty' => false
			)
		)
	);
	
}
?>