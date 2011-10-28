<?php
/**
 * KnowledgebaseArticle Model
 *
 * PHP version 5.3
 * CakePHP version 1.3
 *
 * @package    	knowledgebase
 * @subpackage 	knowledgebase.models
 */
class KnowledgebaseArticle extends KnowledgebaseAppModel {

	/**
	 * @var string
	 */
	public $name = 'KnowledgebaseArticle';
	
	/*
	 * @var	array
	 */
	public $actsAs = array(
		'Containable',
		'Utils.Sluggable' => array(
			'label' => 'title',
			'length' => 255,
			'scope' => array('KnowledgebaseArticle.knowledgebase_portal_id'),
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
			'foreignKey' => 'knowledgebase_article_id',
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
				'message' => 'Please enter a title',
				'allowEmpty' => false,
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Please enter a title no longer than 255 characters',
				'allowEmpty' => false
			)
		),
		'body' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a body',
				'allowEmpty' => false
			)
		)
	);
	
	/**
	 * Search articles using a FULLTEXT natural language query, and return an array of matching articles
	 * 
	 * @author	Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param	int			Portal ID
	 * @param 	string		Query string
	 * @param	array		Options
	 * 						- category_ids	array	Filter by an optional list of Category IDs
	 * @return	array		Array of Articles
	 */
	public function search ($portal_id=0, $query='', $options=array()) {
		
		if (empty($portal_id)) {
			return array();
		}
		
		$options = array_merge(
			array(
				'category_ids' => array()
			),
			$options
		);
		extract($options);
		
		App::import('Core', 'Sanitize');
		
		$article_ids = array();
		if (!empty($category_ids)) {
			$article_ids = array_unique($this->KnowledgebaseArticlesKnowledgebaseCategory->find('list', array(
				'fields' => array('knowledgebase_article_id'),
				'conditions' => array(
					'KnowledgebaseArticlesKnowledgebaseCategory.knowledgebase_category_id' => $category_ids
				),
				'contain' => false
			)));
		}
		
		return $this->query('
		SELECT 
			*
		FROM 
			knowledgebase_articles AS ' . $this->alias . '
		WHERE 
			(knowledgebase_portal_id=' . (int)$portal_id . ') AND 
			' . (!empty($article_ids) ? '(id IN (' . implode(',', $article_ids) . ')) AND ' : '') . '
			(MATCH (title, body) AGAINST ("' . Sanitize::escape($query) . '" IN NATURAL LANGUAGE MODE))
		');
		
	}
	
}
?>