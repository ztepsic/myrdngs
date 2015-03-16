<h2>
	<a title="Web Café" href="<?= site_url("webcafe"); ?>">Web Café</a>
</h2>
<ul class="horizontal-feeds-box">
	<? foreach($ztRssChannelItems as $ztRssChannelItem):?>
	<? 
		$parsedUrlArray = parse_url(prep_url($ztRssChannelItem->GetGuid()));
		$host = isset($parsedUrlArray["host"]) ? $parsedUrlArray["host"] : "";
	?>

	<li class="float-left">
	<a href="<?= site_url("webcafe/clanak/" . $ztRssChannelItem->GetId() . "/" . hr_url_title($ztRssChannelItem->GetTitle()) . "--" . hr_url_title($host)); ?>">
		<?
			$image = $ztRssChannelItem->GetImage();
			if(!empty($image)):
		?>
			<img  class="thumbnail-small float-left" src="<?= $image; ?>" alt="<?= $ztRssChannelItem->GetTitle(); ?>"/>
		<? endif;?>
		
		<strong><?= character_limiter($ztRssChannelItem->GetTitle(), 20); ?></strong>
		<?= character_limiter(strip_tags($ztRssChannelItem->GetDescription()), 60); ?>
		</a>
	</li>
	<? endforeach;?>
</ul>
<div class="clear"></div>