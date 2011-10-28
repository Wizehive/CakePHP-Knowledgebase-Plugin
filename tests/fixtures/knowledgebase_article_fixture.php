<?php

/**
 * KnowledgebaseArticle Fixture
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.fixtures
 * @since       0.1
 * @see         KnowledgebaseArticle
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebaseArticleFixture extends CakeTestFixture {

	/**
	 * @var     string
	 */
	public $name    = 'KnowledgebaseArticle';

	/**
	 * @var     string
	 */
	public $import  = 'Knowledgebase.KnowledgebaseArticle';
	
	/**
	 * @var		array
	 */
	public $records = array(
		array(
			'id' => 1,
			'knowledgebase_portal_id' => 1,
			'slug' => 'first-article',
			'title' => 'First Article',
			'body' => 'First article body',
			'view_count' => 0,
			'created' => '2011-07-05 16:00:00',
			'modified' => '2011-07-05 16:00:00'
		),
		array(
			'id' => 2,
			'knowledgebase_portal_id' => 1,
			'slug' => 'second-article',
			'title' => 'Second Article',
			'body' => 'Second article body',
			'view_count' => 0,
			'created' => '2011-07-05 16:05:00',
			'modified' => '2011-07-05 16:05:00'
		),
		array(
			'id' => 3,
			'knowledgebase_portal_id' => 1,
			'slug' => 'third-article',
			'title' => 'Third Article',
			'body' => 'Third article body with unique content',
			'view_count' => 0,
			'created' => '2011-07-05 16:10:00',
			'modified' => '2011-07-05 16:10:00'
		),
		array(
			'id' => 4,
			'knowledgebase_portal_id' => 2,
			'slug' => 'first-article',
			'title' => 'First Article',
			'body' => 'First article body',
			'view_count' => 0,
			'created' => '2011-07-05 16:00:00',
			'modified' => '2011-07-05 16:00:00'
		),
		array(
			'id' => 5,
			'knowledgebase_portal_id' => 2,
			'slug' => 'second-article',
			'title' => 'Second Article',
			'body' => 'Second article body',
			'view_count' => 0,
			'created' => '2011-07-05 16:05:00',
			'modified' => '2011-07-05 16:05:00'
		),
		array(
			'id' => 6,
			'knowledgebase_portal_id' => 2,
			'slug' => 'third-article',
			'title' => 'Third Article',
			'body' => 'Third article body',
			'view_count' => 0,
			'created' => '2011-07-05 16:10:00',
			'modified' => '2011-07-05 16:10:00'
		),
	);

}

?>