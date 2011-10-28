<?=$this->Form->create('KnowledgebasePortal'); ?>

	<?=$this->Form->input('KnowledgebasePortal.id'); ?>
	
	<?=$this->Form->input('KnowledgebasePortal.title'); ?>

<?=$this->Form->end('Submit'); ?>

<?=$this->element('knowledgebase/portals/admin/actions'); ?>