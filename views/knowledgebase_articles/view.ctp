<h2><?=$article['KnowledgebaseArticle']['title']; ?></h2>

<?=$article['KnowledgebaseArticle']['body']; ?>

<? if (!empty($article['KnowledgebaseArticlesKnowledgebaseCategory'])) { ?>

	<div id="article-categories">

		<h3>Found in the following categories:</h3>
		
		<ul>
			<? foreach ($article['KnowledgebaseArticlesKnowledgebaseCategory'] as $category) { ?>
				<li><?=$this->Html->link(
					$category['KnowledgebaseCategory']['title'],
					array(
						'plugin' => $this->params['plugin'],
						'controller' => 'knowledgebase_portals',
						'action' => 'view',
						'portal_slug' => $portal['KnowledgebasePortal']['slug'],
						'category' => $category['KnowledgebaseCategory']['slug']
					)
				); ?></li>
			<? } ?>
		</ul>
		
		<div>&nbsp;</div>
	
	</div>
	
<? } ?>