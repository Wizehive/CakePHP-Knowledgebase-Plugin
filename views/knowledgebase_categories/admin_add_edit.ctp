<?=$this->Form->create(
	'KnowledgebaseCategory', 
	array(
		'url' => $this->here
	)
); ?>

	<?=$this->Form->input('KnowledgebaseCategory.id'); ?>
	
	<?=$this->Form->input('KnowledgebaseCategory.knowledgebase_portal_id', array('type' => 'hidden')); ?>
	<h2>Knowledgebase Portal: <?=$portal['KnowledgebasePortal']['title']; ?></h2>
	
	<?=$this->Form->input('KnowledgebaseCategory.title', array('label' => 'Category Title')); ?>

<?=$this->Form->end('Submit'); ?>

<?=$this->element('knowledgebase/categories/admin/actions'); ?>