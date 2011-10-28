CREATE TABLE IF NOT EXISTS `knowledgebase_articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `knowledgebase_portal_id` int(11) unsigned NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `view_count` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledgebase_portal_slug_idx` (`knowledgebase_portal_id`,`slug`),
  KEY `created_idx` (`created`),
  KEY `view_count_idx` (`view_count`),
  FULLTEXT KEY `title_body_idx` (`title`,`body`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `knowledgebase_articles_knowledgebase_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `knowledgebase_article_id` int(11) unsigned NOT NULL,
  `knowledgebase_category_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledgebase_article_knowledgebase_category_idx` (`knowledgebase_article_id`,`knowledgebase_category_id`),
  KEY `knowledgebase_category_idx` (`knowledgebase_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `knowledgebase_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `knowledgebase_portal_id` int(11) unsigned NOT NULL DEFAULT '0',
  `slug` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `article_count` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledgebase_portal_slug_idx` (`knowledgebase_portal_id`,`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `knowledgebase_portals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_idx` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;