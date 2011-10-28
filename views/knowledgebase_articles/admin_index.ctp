<? if (empty($articles)) { ?>

	No articles were found.

<? } else { ?>

<table>
	<tr>
		<th>Title</th>
		<th style="width: 200px">Created</th>
		<th style="width: 100px" class="actions">&nbsp;</th>
	</tr>
	<?
	$count = 0;
	foreach ($articles as $article) { ?>
		<tr<? if ($count %2) echo ' class="altrow"'; ?>>
			<td style="text-align: left"><?
			echo $article['KnowledgebaseArticle']['title'] . ' ' . $this->Html->link(
				'[+]',
				'#',
				array('class' => 'expand-link')
			);
			echo '<div style="display: none">' . $article['KnowledgebaseArticle']['body'] . '</div>';
			?></td>
			<td><?=$article['KnowledgebaseArticle']['created']; ?></td>
			<td class="actions">
				<?=$this->Html->link(
					'Edit',
					array(
						'action' => 'edit',
						$article['KnowledgebaseArticle']['id'],
						'portal_slug' => $portal['KnowledgebasePortal']['slug']
					)
				); ?>
				<?=$this->Html->link(
					'Delete',
					array(
						'action' => 'delete',
						$article['KnowledgebaseArticle']['id']
					),
					array(),
					'Are you sure you wish to delete this article?'
				); ?>
			</td>
		</tr>
		<?
		$count++;
	}
	?>
</table>

<? } ?>

<?=$this->element('knowledgebase/articles/admin/actions'); ?>

<? $this->Html->scriptBlock('

	jQuery(document).ready(function(){
	
		$(".expand-link").click(function(){
			$(this).siblings("div").toggle();
			return false;
		});
	
	});

', array('inline' => false));