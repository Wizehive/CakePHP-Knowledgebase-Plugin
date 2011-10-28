<?php
/**
 * KnowledgebaseArticlesKnowledgebaseCategory Model
 *
 * PHP version 5.3
 * CakePHP version 1.3
 *
 * @package    	knowledgebase
 * @subpackage 	knowledgebase.models
 */
class KnowledgebaseArticlesKnowledgebaseCategory extends KnowledgebaseAppModel {

	/**
	 * @var string
	 */
	public $name = 'KnowledgebaseArticlesKnowledgebaseCategory';
	
	/*
	 * @var	array
	 */
	public $actsAs = array(
		'Containable'
	);
	
	/*
	 * @var	array
	 */
	public $belongsTo = array(
		'KnowledgebaseArticle' => array(
			'className' => 'Knowledgebase.KnowledgebaseArticle',
			'foreignKey' => 'knowledgebase_article_id'
		),
		'KnowledgebaseCategory' => array(
			'className' => 'Knowledgebase.KnowledgebaseCategory',
			'foreignKey' => 'knowledgebase_category_id',
			'counterCache' => 'article_count'
		)
	);
	
	/**
	 * Remove deleted joins
	 * 
	 * @author	Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param 	array	Existing joins
	 * @param	array	New joins
	 * @return	bool
	 */
	public function removeDeletedJoins ($existing_joins=array(), $new_joins=array()) {
		
		$success = true;
		
		if (!empty($new_joins)) {
			foreach ($new_joins as $new_join) {
				if (empty($new_join['is_checked'])) {
					if (!empty($existing_joins)) {
						foreach ($existing_joins as $existing_join) {
							if ($existing_join['knowledgebase_category_id'] == $new_join['knowledgebase_category_id']) {
								if (!$this->delete($existing_join['id'])) {
									$success = false;
									break 2;
								}
							}
						}
					}
				}
			}
		}
		
		if (!$success) {
			return array('success' => false, 'new_joins' => $new_joins);
		}
		
		if (!empty($new_joins)) {
			foreach ($new_joins as $key => $new_join) {
				if (empty($new_join['is_checked'])) {
					unset($new_joins[$key]);
				}
			}
		}
		
		return array('success' => true, 'new_joins' => $new_joins);
		
	}
	
}
?>