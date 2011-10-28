<? if (empty($portals)) { ?>

	No portals were found.

<? } else { ?>

<table>
	<tr>
		<th>Name</th>
		<th>Created</th>
		<th class="actions">&nbsp;</th>
	</tr>
	<? foreach ($portals as $portal) { ?>
		<tr>
			<td><?=$portal['KnowledgebasePortal']['title']; ?></td>
			<td><?=$portal['KnowledgebasePortal']['created']; ?></td>
			<td class="actions">
				<?=$this->Html->link(
					'Edit',
					array(
						'action' => 'edit',
						$portal['KnowledgebasePortal']['id']
					)
				); ?>
				<?=$this->Html->link(
					'Delete',
					array(
						'action' => 'delete',
						$portal['KnowledgebasePortal']['id']
					),
					array(),
					'Are you sure you wish to delete this portal?'
				); ?>
				<?=$this->Html->link(
					'List Articles',
					array(
						'controller' => 'knowledgebase_articles',
						'action' => 'index',
						$portal['KnowledgebasePortal']['id']
					)
				); ?>
				<?=$this->Html->link(
					'List Categories',
					array(
						'controller' => 'knowledgebase_categories',
						'action' => 'index',
						$portal['KnowledgebasePortal']['id']
					)
				); ?>
			</td>
		</tr>
	<? } ?>
</table>

<? } ?>

<?=$this->element('knowledgebase/portals/admin/actions'); ?>