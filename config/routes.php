<?php
/**
 * Plugin Routes File
 *
 * Include this file in your app's `routes.php` file 
 * or use as a template for your own unique routes
 *
 * @package     knowledgebase
 * @subpackage  knowledgebase.config
 * @since       0.1
 * @author		Anthony Putignano <anthony@wizehive.com>
 */

Router::connectNamed(array(
	'category' => array(
		'plugin' => 'knowledgebase',
		'controller' => array('knowledgebase_portals', 'knowledgebase_articles'),
		'action' => array('index', 'view')
	),
	'portal_slug' => array(
		'plugin' => 'knowledgebase',
		'controller' => array('knowledgebase_articles', 'knowledgebase_categories'),
		'action' => array('add', 'edit')
	)
));
Router::connect('/admin/kb', array('plugin' => 'knowledgebase', 'controller' => 'knowledgebase_portals', 'action' => 'index', 'prefix' => 'admin'));
Router::connect('/admin/kb/portals/:action/*', array('plugin' => 'knowledgebase', 'controller' => 'knowledgebase_portals', 'prefix' => 'admin'));
Router::connect('/admin/kb/articles/:action/*', array('plugin' => 'knowledgebase', 'controller' => 'knowledgebase_articles', 'prefix' => 'admin'));
Router::connect('/admin/kb/categories/:action/*', array('plugin' => 'knowledgebase', 'controller' => 'knowledgebase_categories', 'prefix' => 'admin'));
Router::connect('/kb/:portal_slug/articles/search/*', array('plugin' => 'knowledgebase', 'controller' => 'knowledgebase_articles', 'action' => 'index'));
Router::connect('/kb/:portal_slug/articles/:article_slug', array('plugin' => 'knowledgebase', 'controller' => 'knowledgebase_articles', 'action' => 'view'));
Router::connect('/kb/:portal_slug/*', array('plugin' => 'knowledgebase', 'controller' => 'knowledgebase_portals', 'action' => 'view'));