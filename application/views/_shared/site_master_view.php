<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $this->config->item('zt_site_lang'); ?>" xml:lang="<?= $this->config->item('zt_site_lang'); ?>">
    <head>
		<?= isset($head) ? $head : "" ?>
	</head>
	<body>
		<div id="header">
			<div class="container_12">
				<div class="grid_12">
					<ul id="top-navigation">
						<li><a href="<?= base_url(); ?>" title="Naslovnica">Naslovnica</a></li>
						<li><a href="<?= site_url("lektire"); ?>" title="Lektire">Lektire</a></li>
						<li><a href="<?= site_url("pisci"); ?>" title="Pisci">Pisci</a></li>
						<li><a href="<?= site_url("lektire/upload"); ?>" title="Pošalji lektiru">Pošalji lektiru</a></li>
						<li><a href="<?= site_url("informacije/najcesca-pitanja"); ?>" title="Najčešća pitanja">Najčešća pitanja</a></li>
					</ul>
					<div id="logo">
	                	<a href="<?= base_url(); ?>" title="<?= $this->config->item('zt_site_title'); ?>">
	                		<img title="<?= $this->config->item('zt_site_title'); ?>" src="<?= static_url("img/moje_lektire_logo.png"); ?>"/>
	                    </a>
		            </div> <!-- END #logo -->
					<?= isset($downHeader) ? $downHeader : "" ?>
				</div> <!-- END .grid_12 -->
				<div class="clear"></div>

			</div> <!-- END .container_12 -->

		</div> <!-- END #header -->

		<div id="content">
			<div class="container_12">
				<div class="grid_12" id="contentTop">
					<?= isset($contentTop) ? $contentTop : "" ?>
				</div> <!-- END .grid_12 -->
				<div class="clear"></div>
				
				<?= isset($template) ? $template : "" ?>
				
				<div class="grid_12">
					<?= isset($contentBottom) ? $contentBottom : "" ?>
				</div> <!-- END .grid_12 -->
				<div class="clear"></div>

			</div> <!-- END .container_12 -->
		</div> <!-- END #content -->

		<div id="footer">
			<div class="container_12">
				<?= isset($footer) ? $footer : "" ?>

				<div class="clear"></div>

			</div> <!-- END .container_12 -->
		</div> <!-- END #footer -->
		
		<?= isset($googleAnalytics) ? $googleAnalytics : "" ?>

	</body>
</html>