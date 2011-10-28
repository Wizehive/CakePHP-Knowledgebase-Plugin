<? if (empty($articles)) { ?>

	No search results found for '<?=$this->params['url']['query']; ?>'

<? } else { ?>

	<? foreach ($articles as $article) { ?>
	
		<?=$this->Html->link(
			$this->KnowledgebaseSearch->highlightArticleTitle($article['KnowledgebaseArticle']['title'], $this->params['url']['query']),
			array(
				'plugin' => $this->params['plugin'],
				'controller' => $this->params['controller'],
				'action' => 'view',
				'portal_slug' => $portal['KnowledgebasePortal']['slug'],
				'article_slug' => $article['KnowledgebaseArticle']['slug']
			),
			array(
				'class' => 'article-index-title',
				'escape' => false
			)
		); ?>
		
		<div class="article-index-body">
			<?=$this->KnowledgebaseSearch->highlightArticleBody($article['KnowledgebaseArticle']['body'], $this->params['url']['query']); ?>
		</div>
	
	<? } ?>
	
<? } ?>