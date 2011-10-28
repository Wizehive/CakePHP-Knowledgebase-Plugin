<?=$this->Html->script('/' . $this->params['plugin'] . '/js/jquery.livesearch', array('inline' => false)); ?>

<?=$this->Form->input(
	'query',
	array(
		'name' => 'query',
		'label' => 'Search ' . $portal['KnowledgebasePortal']['title'],
		'div' => array(
			'id' => 'search'
		)
	)
); ?>

<div id="article-content">

	<? 
	if (!empty($articles)) {
		if (empty($this->params['named']['category'])) {
			echo '<h2>Top 20</h2>';
			echo '<ol>';
		} else {
			echo '<h2>' . $category['KnowledgebaseCategory']['title'] . '</h2>';
			echo '<ul>';
		}
		foreach ($articles as $article) {
			echo '<li>' . $this->Html->link(
				$article['KnowledgebaseArticle']['title'],
				array(
					'plugin' => $this->params['plugin'],
					'controller' => 'knowledgebase_articles',
					'action' => 'view',
					'portal_slug' => $portal['KnowledgebasePortal']['slug'],
					'article_slug' => $article['KnowledgebaseArticle']['slug']
				),
				array(
					'escape' => false
				)
			) . '</li>';
		}
		echo empty($this->params['named']['category']) ? '</ol>' : '</ul>';
	}
	?>

</div>

<?=$this->Html->scriptBlock('
	
	$(document).ready(function(){
		$("#search input").livesearch({
			searchCallback: searchFunction,
			queryDelay: 250,
			innerText: "Enter a question, keyword, or topic...",
			minimumSearchLength: 4
		});
		function searchFunction (searchTerm) {
			$.ajax({
				url: "' . $this->Html->url(array_merge(
					array(
						'plugin' => $this->params['plugin'],
						'controller' => 'knowledgebase_articles',
						'action' => 'index',
						'portal_slug' => $portal['KnowledgebasePortal']['slug']
					),
					!empty($this->params['named']['category']) ? array(
						'category' => $this->params['named']['category']
					) : array()
				)) . '",
				data: {
					query: searchTerm
				},
				success: function(searchResults){
					$("#article-content").html(searchResults);
				}
			});
		}
	});

', array('inline' => false));