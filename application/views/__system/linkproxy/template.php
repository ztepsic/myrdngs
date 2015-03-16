<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $this->config->item('site_lang'); ?>" xml:lang="<?= $this->config->item('site_lang'); ?>">
    <head>
		<?= isset($head) ? $head : "" ?>
	</head>
	<frameset frameborder="0" rows="<?= $headerRows ?>,*">
    	<frame scrolling="no" src="<?= $headerUrl; ?>"/>
    	<frame src="<?= $url ?>"/>
    	<noframes>
    		<body>
    			<?= isset($noFrames) ? $noFrames : "" ?>    
    		</body>
    	</noframes>
	</frameset>
	
	<?= isset($googleAnalytics) ? $googleAnalytics : "" ?>
</html>