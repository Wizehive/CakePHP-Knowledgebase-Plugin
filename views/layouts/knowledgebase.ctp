<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<?=$this->Html->charset(); ?>
		<title><?=$title_for_layout; ?></title>
		<?php
			echo $this->Html->meta('icon');
			
			echo $this->Html->css('/' . $this->params['plugin'] . '/css/resets');
			echo $this->Html->css('/' . $this->params['plugin'] . '/css/main');
			
			if (Configure::read('Knowledgebase.css')) {
				echo $this->Html->css(Configure::read('Knowledgebase.css'));
			}
			
			echo $this->Html->script('/' . $this->params['plugin'] . '/js/jquery-1.6.2.min');
	
			echo $scripts_for_layout;
		?>
	</head>
	
	<body>
	
		<div id="container">
		
			<div id="content">
				
				<div id="sidebar">
				
					<div id="portal-identifier">
						<?
						if (Configure::read('Knowledgebase.logo_image')) {
							echo $this->Html->link(
								$this->Html->image(Configure::read('Knowledgebase.logo_image')),
								array(
									'plugin' => $this->params['plugin'],
									'controller' => 'knowledgebase_portals',
									'action' => 'view',
									'portal_slug' => $portal['KnowledgebasePortal']['slug']
								),
								array(
									'alt' => $portal['KnowledgebasePortal']['title'],
									'escape' => false
								)
							);
						} else {
							echo '<h1>' . $this->Html->link(
								$portal['KnowledgebasePortal']['title'],
								array(
									'plugin' => $this->params['plugin'],
									'controller' => 'knowledgebase_portals',
									'action' => 'view',
									'portal_slug' => $portal['KnowledgebasePortal']['slug']
								),
								array(
									'escape' => false
								)
							) . '</h1>';
						}
						?>
					</div>
				
					<div id="categories">
						<?
						if (!empty($portal['KnowledgebaseCategory'])) {
							echo '<ul>';
							foreach ($portal['KnowledgebaseCategory'] as $category) {
								echo '<li>' . $this->Html->link(
									$category['title'],
									array(
										'plugin' => $this->params['plugin'],
										'controller' => 'knowledgebase_portals',
										'action' => 'view',
										'portal_slug' => $portal['KnowledgebasePortal']['slug'],
										'category' => $category['slug']
									),
									array(
										'escape' => false
									)
								) . ' (' . number_format($category['article_count']) . ')' . '</li>';
							}
							echo '</ul>';
						}
						?>
					</div>
					
				</div>
				
				<div id="inner-content">
				
					<div id="breadcrumb"><?=$title_for_layout; ?></div>
	
					<?=$this->Session->flash(); ?>
					
					<div id="inner-content-body">
					
						<?=$content_for_layout; ?>
					
					</div>
				
				</div>
				
				<div>&nbsp;</div>
	
			</div>
			
		</div>
		
	</body>

</html>