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
class KnowledgebaseAppModel extends AppModel {
	
	/**
	 * Name of datasource config to use
	 *
	 * @var string
	 */
	public $useDbConfig = 'knowledgebase';
	
	/**
	 * Adds the datasource to the connection manager if it's not already there,
	 * which it won't be if you've not added it to your app/config/database.php
	 * file.
	 * 
	 * @author	Anthony Putignano <anthony@wizehive.com>
	 * @since	0.1
	 * @param 	int
	 * @param 	string
	 * @param 	string
	 * @return	void
	 */
	public function __construct ($id = false, $table = null, $ds = null) {

		$sources = ConnectionManager::sourceList();
		
		if (!in_array('knowledgebase', $sources)) {
			$dbConfig = new DATABASE_CONFIG();
			ConnectionManager::create('knowledgebase', $dbConfig->default);
		}
		
		parent::__construct($id, $table, $ds);

	}
	
}
?>