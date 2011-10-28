<?=$this->Form->create(
	'KnowledgebaseArticle',
	array(
		'url' => $this->here
	)
); ?>

	<?=$this->Form->input('KnowledgebaseArticle.id'); ?>
	
	<?=$this->Form->input('KnowledgebaseArticle.knowledgebase_portal_id', array('type' => 'hidden')); ?>
	<h2>Knowledgebase Portal: <?=$portal['KnowledgebasePortal']['title']; ?></h2>
	
	<?=$this->Form->input('KnowledgebaseArticle.title', array('label' => 'Article Title')); ?>
	
	<?=$this->Form->input('KnowledgebaseArticle.body', array('class' => 'wysiwyg')); ?>
	
	<fieldset>
	
		<legend>Categories</legend>
	
		<?
		//TODO(anthony@wizehive.com): Logic this complex should be in a helper
		$count = 0;
		foreach ($category_list as $category_id => $category) {
			$existing = null;
			if (!empty($article['KnowledgebaseArticlesKnowledgebaseCategory'])) {
				foreach ($article['KnowledgebaseArticlesKnowledgebaseCategory'] as $category_join) {
					if ($category_id == $category_join['knowledgebase_category_id']) {
						$existing = $category_join;
						break;
					}
				}
			}
			$checked = false;
			if (!empty($this->data['KnowledgebaseArticlesKnowledgebaseCategory'])) {
				foreach ($this->data['KnowledgebaseArticlesKnowledgebaseCategory'] as $category_join) {
					if (
						$category_id == $category_join['knowledgebase_category_id'] &&
						(
							!empty($category_join['is_checked']) || 
							!array_key_exists('is_checked', $category_join)
						)
					) {
						$checked = true;
						break;
					}
				}
			}
			echo $this->Form->input('KnowledgebaseArticlesKnowledgebaseCategory.' . $count . '.id', array(
				'type' => 'hidden',
				'value' => (!empty($existing) ? $existing['id'] : '')
			));
			echo $this->Form->input('KnowledgebaseArticlesKnowledgebaseCategory.' . $count . '.knowledgebase_category_id', array(
				'type' => 'hidden',
				'value' => $category_id
			));
			echo $this->Form->input('KnowledgebaseArticlesKnowledgebaseCategory.' . $count . '.is_checked', array(
				'type' => 'checkbox',
				'label' => $category,
				'checked' => $checked
			));
			$count++;
		}
		?>
	
	</fieldset>

<?=$this->Form->end('Submit'); ?>

<?=$this->element('knowledgebase/articles/admin/actions'); ?>