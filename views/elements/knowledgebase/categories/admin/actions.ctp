<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?=$this->Html->link(
			'New Category', 
			array('controller' => 'knowledgebase_categories', 'action' => 'add', 'portal_slug' => $portal['KnowledgebasePortal']['slug'])
		); ?></li>
		<? if (!empty($portal)) { ?>
			<li><?=$this->Html->link(
				'List Categories',
				array('controller' => 'knowledgebase_categories', 'action' => 'index', $portal['KnowledgebasePortal']['id'])
			); ?></li>
			<li><?=$this->Html->link(
				'List Articles',
				array('controller' => 'knowledgebase_articles', 'action' => 'index', $portal['KnowledgebasePortal']['id'])
			); ?></li>
		<? } ?>
		<li><?=$this->Html->link(
			'List Portals',
			array('controller' => 'knowledgebase_portals', 'action' => 'index')
		); ?></li>
	</ul>
</div>