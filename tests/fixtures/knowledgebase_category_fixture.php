<?php

/**
 * KnowledgebaseCategory Fixture
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.fixtures
 * @since       0.1
 * @see         KnowledgebaseCategory
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseCategoryFixture extends CakeTestFixture {

	/**
	 * @var     string
	 */
	public $name    = 'KnowledgebaseCategory';

	/**
	 * @var     string
	 */
	public $import  = 'Knowledgebase.KnowledgebaseCategory';
	
	/**
	 * @var		array
	 */
	public $records = array(
		array(
			'id' => 1,
			'knowledgebase_portal_id' => 1,
			'slug' => 'first-category',
			'title' => 'First Category',
			'article_count' => 3,
			'created' => '2011-07-05 16:00:00',
			'modified' => '2011-07-05 16:00:00'
		),
		array(
			'id' => 2,
			'knowledgebase_portal_id' => 1,
			'slug' => 'second-category',
			'title' => 'Second Category',
			'article_count' => 1,
			'created' => '2011-07-05 16:00:00',
			'modified' => '2011-07-05 16:00:00'
		),
		array(
			'id' => 3,
			'knowledgebase_portal_id' => 2,
			'slug' => 'first-category',
			'title' => 'First Category',
			'article_count' => 2,
			'created' => '2011-07-05 16:00:00',
			'modified' => '2011-07-05 16:00:00'
		)
	);

}

?>