<!DOCTYPE html>
<html>
<head>
	<title>
		RevHero: <?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="shortcut icon" href="favicon.ico"/>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.css');
	
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('bootstrap');
	?>
</head>
<body>
	<div id="container">
		<?php /*?><div id="header">
			<h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div><?php */?>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->element('header'); ?>
			<?php echo $this->fetch('content'); ?>
			<?php //echo $this->element('footer'); ?>
		</div>
		<div id="footer">
			<?php /*echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);*/
			?>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
