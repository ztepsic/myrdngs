<div class="letters-navigation">
	<ul>
	<? foreach ($items as $item): ?>
	<?
		$class = "";
		if(strcasecmp($item->GetTitle(), $activeLetter) == 0){
			$class = "active";
		}
	?>
		<li class="<?= $class; ?>"><a href="<?= $item->GetUri(); ?>" title="<?= $item->GetTitle(); ?>"><span><?= $item->GetTitle(); ?></span></a></li>
	<? endforeach; ?>
	</ul>
</div> <!-- END .letters-navigation -->
<div style="background: #f4f5f6; width: 99%; padding: 2px 5px; margin-bottom: 20px ">
	<a title="<?= $this->config->item('zt_site_title'); ?>" href="<?= base_url(); ?>" class="fav"><img width="24" height="24" src="<?= static_url("img/favorite.png"); ?>"/></a>
	<script type="text/javascript">$(".fav").jFav();</script>

	<strong>
		<a href="<?= site_url(strtolower($title)); ?>"><?= $title; ?></a>
	</strong>
	
	<span style="margin: 0px 0 0 40px; padding-top: 5px;">
			<script type="text/javascript"><!--
google_ad_client = "pub-7017843381666306";
/* moje.lektire, links 728x15 */
google_ad_slot = "2000044106";
google_ad_width = 728;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
	</span>

</div>