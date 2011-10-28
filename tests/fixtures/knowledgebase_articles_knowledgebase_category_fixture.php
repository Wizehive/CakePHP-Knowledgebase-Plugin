<?php

/**
 * KnowledgebaseArticlesKnowledgebaseCategory Fixture
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.fixtures
 * @since       0.1
 * @see         KnowledgebaseArticlesKnowledgebaseCategory
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseArticlesKnowledgebaseCategoryFixture extends CakeTestFixture {

	/**
	 * @var     string
	 */
	public $name    = 'KnowledgebaseArticlesKnowledgebaseCategory';

	/**
	 * @var     string
	 */
	public $import  = 'Knowledgebase.KnowledgebaseArticlesKnowledgebaseCategory';
	
	/**
	 * @var		array
	 */
	public $records = array(
		array(
			'id' => 1,
			'knowledgebase_article_id' => 1,
			'knowledgebase_category_id' => 1
		),
		array(
			'id' => 2,
			'knowledgebase_article_id' => 2,
			'knowledgebase_category_id' => 1
		),
		array(
			'id' => 3,
			'knowledgebase_article_id' => 3,
			'knowledgebase_category_id' => 1
		),
		array(
			'id' => 4,
			'knowledgebase_article_id' => 2,
			'knowledgebase_category_id' => 2
		),
		array(
			'id' => 5,
			'knowledgebase_article_id' => 5,
			'knowledgebase_category_id' => 3
		),
		array(
			'id' => 6,
			'knowledgebase_article_id' => 6,
			'knowledgebase_category_id' => 3
		)
	);

}

?>