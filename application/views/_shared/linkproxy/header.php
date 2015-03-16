<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $this->config->item('site_lang'); ?>" xml:lang="<?= $this->config->item('site_lang'); ?>">
    <head>
		<?= isset($head) ? $head : "" ?>
	</head>
	<body style="background: #111111; border-bottom: 5px solid #666666;">
		<div class="container_12">	
			<div class="grid_12">
				<div class="float-left">
					<ul style="list-style: none; margin: 10px;">
					<? if(isset($links)): ?>
						<? foreach($links as $linkName => $link): ?>
						<li><a href="<?= prep_url($link); ?>" title="<?= $linkName; ?>" target="_blank"><?= $linkName; ?></a></li>
						<? endforeach;?>
					<? endif;?>
					</ul>
				</div>
				<?= isset($ad) ? $ad : "" ?>
			</div> <!-- END .grid_12 -->
			<div class="alt">
			<?= isset($content) ? $content : "" ?>
			</div>
			<div class="clear"></div>
			<?= $this->config->item("zt_google_analytics"); ?>
	</body>
</html>

