<?php
/**
 * Plugin Configuration File
 *
 * In order to make the plugin work you must include this file
 * in your app's `core.php` file. You can override any of the
 * settings in here by re-defining them in your app's `core.php`
 * file.
 *
 * PHP version 5.3
 * CakePHP version 1.3
 *
 * @package    	knowledgebase
 * @subpackage 	knowledgebase.config
 * @since		0.1
 * @author		Anthony Putignano <anthony@wizehive.com>
 */

Configure::write('Knowledgebase.top_articles_count', 20);
Configure::write('Knowledgebase.CKEditor.configs', array(
	'toolbar' => array(
		array('Bold', 'Italic', 'Underline', '-', 'Link', 'Unlink', '-', 'Image')
	),
	'height' => 200
));
// The path of a custom logo file inside `webroot/img/`
Configure::write('Knowledgebase.logo_image', '');
// The path of a custom CSS file inside `webroot/css/`
Configure::write('Knowledgebase.css', '');

?>