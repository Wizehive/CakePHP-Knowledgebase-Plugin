<? if (empty($categories)) { ?>

	No categories were found.

<? } else { ?>

<table>
	<tr>
		<th>Name</th>
		<th>Created</th>
		<th class="actions">&nbsp;</th>
	</tr>
	<? foreach ($categories as $category) { ?>
		<tr>
			<td><?=$category['KnowledgebaseCategory']['title']; ?></td>
			<td><?=$category['KnowledgebaseCategory']['created']; ?></td>
			<td class="actions">
				<?=$this->Html->link(
					'Edit',
					array(
						'action' => 'edit',
						$category['KnowledgebaseCategory']['id'],
						'portal_slug' => $portal['KnowledgebasePortal']['slug']
					)
				); ?>
				<?=$this->Html->link(
					'Delete',
					array(
						'action' => 'delete',
						$category['KnowledgebaseCategory']['id']
					),
					array(),
					'Are you sure you wish to delete this category?'
				); ?>
			</td>
		</tr>
	<? } ?>
</table>

<? } ?>

<?=$this->element('knowledgebase/categories/admin/actions'); ?>