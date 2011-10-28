<?php

/**
 * KnowledgebasePortal Fixture
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.tests.fixtures
 * @since       0.1
 * @see         KnowledgebasePortal
 * @author      Anthony Putignano <anthony@wizehive.com>
 */
class KnowledgebasePortalFixture extends CakeTestFixture {

	/**
	 * @var     string
	 */
	public $name    = 'KnowledgebasePortal';

	/**
	 * @var     string
	 */
	public $import  = 'Knowledgebase.KnowledgebasePortal';
	
	/**
	 * @var		array
	 */
	public $records = array(
		array(
			'id' => 1,
			'slug' => 'portal-1',
			'title' => 'Portal 1',
			'created' => '2011-07-05 16:00:00',
			'modified' => '2011-07-05 16:00:00'
		),
		array(
			'id' => 2,
			'slug' => 'portal-2',
			'title' => 'Portal 2',
			'created' => '2011-07-05 16:00:00',
			'modified' => '2011-07-05 16:00:00'
		)
	);

}

?>