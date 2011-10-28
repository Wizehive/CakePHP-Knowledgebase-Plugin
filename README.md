# Knowledgebase Plugin for CakePHP 1.3+

This plug-and-play knowledgebase system for your CakePHP application can be used to create one or more knowledgebase portals. Knowledgebase articals can be populated into the portals via simple WYSIWYG editing. The portal can then be browsed by category or searched via keyword.

A live example of the frontend can be found here:
http://www.wizehive.com/kb/example-portal

## Installation

1. Extract the downloaded archive from [here](http://github.com/Wizehive/CakePHP-Knowledgebase-Plugin/zipball/master)
2. Move or copy the extracted directory Wizehive-CakePHP-Knowledgebase-Plugin-[hash] to /path/to/your/app/plugins/knowledgebase
3. Import database tables from `config/sql/knowledgebase.sql`
4. Follow the instructions at the top of the knowledgebase's `config/core.php` and `config/routes.php` files

## Dependencies

1. The CakePHP CKEditor plugin must be installed in the same app. Code and instructions available here: https://github.com/Wizehive/CakePHP-CKEditor-Plugin
2. The utils plugin must be installed in the same app. Code and instructions available here: https://github.com/CakeDC/utils

## Instructions / Currently Supported Functionality

### Admin Access & Security

There is no admin security baked into the plugin, so it is important that you implement a security mechanism at your app level. For example, you may include code similar to this in your `AppController::beforeFilter()`:

	if (!empty($this->params['plugin']) && $this->params['plugin'] == 'knowledgebase') {
		if (!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			// code that interacts with Auth or other security mechanism to check the user's access level and allow/disallow admin access
		} else {
			// code that interacts with Auth or other security mechanism to allow the user access to this public knowledgebase page
		}
	}

### Changing the Look & Feel

A few settings on the frontend - such as the logo & CSS overrides - can be easily changing using overrides of the settings found in the knowledgebase's `config/core.php`.

However, should you choose to completely change the layout presented by the knowledgebase, you can easily do that by placing override files in your app's `views/plugins/knowledgebase/` directory. Any files in this path should match the folder & file names found in the Knowledgebase plugin itself.

### Using a custom database for the Knowledgebase

The Knowledgebase plugin expects a database configuration named `knowledgebase`. If it does not exist, it is automatically created and connects itself to your `default` database. To use a different database, simply specify a `knowledgebase` database configuration in your app's `config/database.php`.

### Routing

By default, the admin end can be accessed at `/admin/kb` and the frontend can be accessed at `/kb/[portal-slug-here]`. All rules are specified in the plugin's `config/routes.php`. To change routing behavior, just copy these routes as a template, paste them into your app's `config/routes.php`, and customize to your liking.

## Roadmap

* Add unit tests for admin end
* Allow articles to be shared between portals on admin end
* Allow conditional content in articles based on portal the content is being rendered in

## Known Issues

* Logos apply to every portal in the plugin and cannot currently be customized on a per-portal basis

## Authors

See the AUTHORS file.

## Copyright & License

Knowledgebase Plugin for CakePHP is Copyright (c) 2011 WizeHive, Inc. if not otherwise stated. The code is distributed under the terms of the MIT License. For the full license text see the LICENSE file.