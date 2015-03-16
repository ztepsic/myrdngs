<h2><a href="<?=site_url("webcafe/kategorija/" . $ztRssChannelCategory->GetId() . "/" . hr_url_title($ztRssChannelCategory->GetName())); ?>" title="<?= $ztRssChannelCategory->GetName(); ?>"><?= $ztRssChannelCategory->GetName(); ?></a></h2>
<ul class="vertical-feeds-box">
	<? foreach($ztRssChannelItems as $ztRssChannelItem):?>
	<? 
		$parsedUrlArray = parse_url(prep_url($ztRssChannelItem->GetGuid()));
		$host = isset($parsedUrlArray["host"]) ? $parsedUrlArray["host"] : "";
	?>

	<li class="float-left">
	<a href="<?= site_url("webcafe/clanak/" . $ztRssChannelItem->GetId() . "/" . hr_url_title($ztRssChannelItem->GetTitle()) . "--" . hr_url_title($host)); ?>" target="_blank">
		<?
			$image = $ztRssChannelItem->GetImage();
			if(!empty($image)):
		?>
			<img class="thumbnail float-left" src="<?= $image; ?>" alt="<?= $ztRssChannelItem->GetTitle(); ?>"/>
		<? endif;?>
		
		<strong><?= $ztRssChannelItem->GetTitle(); ?></strong>
		<?= character_limiter(strip_tags($ztRssChannelItem->GetDescription()), 90); ?>
		</a>
	</li>
	<? endforeach;?>
</ul>
<div class="clear"></div>