<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?=$this->Html->link(
			'New Portal', 
			array('controller' => 'knowledgebase_portals', 'action' => 'add')
		); ?></li>
		<li><?=$this->Html->link(
			'List Portals', 
			array('controller' => 'knowledgebase_portals', 'action' => 'index')
		); ?></li>
	</ul>
</div>