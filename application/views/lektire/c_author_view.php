<ul class="entry-meta">
	<li>
        <?
        $authorBooks = $this->booksModel->GetBooksByAuthor($author->GetId());
		$authorBooksCount = count($authorBooks);
        ?>
        Dostupno autorovih djela: <?= $authorBooksCount; ?>
	</li>
</ul> <!-- .entry-meta -->

<?php 
			
	$shareQueryString = array(
		"u" => site_url("pisac/" . idalias_url_title($author->GetId(), $author->GetFullName())),
		"t" => $author->GetFullName() . " | " . $this->config->item("zt_site_title") . " - " . $this->config->item("zt_site_slogan"),
		"d" => character_limiter(strip_tags($author->GetInfo()), 340)
	);
			
?>

<div class="float-left" style="margin: 0 10px 10px 0;">
	<?= $ad; ?>
</div>

<?= $author->GetInfo(); ?>
<div class="clear"></div>


<ul class="inlinebar">
	<li class="first title">Podijeli sa svijetom:</li>
	<li>
		<a title="Pošalji mail prijatelju" href="mailto:?body=<?= site_url("autor/" . idalias_url_title($author->GetId(), $author->GetFullName())); ?>&amp;subject=<?= urlencode($author->GetFullName()); ?>">
			<img alt="Pošalji mail prijatelju" class="share_mail socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>			
	<li>
		<? $shareQueryString["s"] = "facebook"; ?>
		<a title="Podijeli na Facebooku" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Podjeli na Facebooku" class="share_facebook socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "croportal"; ?>
		<a title="Objavi na Croportal" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Objavi na Croportal" class="share_croportal socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "twitter"; ?>
		<a title="Spomeni na Twitteru" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Spomeni na Twitteru" class="share_twitter socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "zrikka"; ?>
		<a title="Spomeni na Zrikki" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Spomeni na Zrikki" class="share_zrikka socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "buzz"; ?>
		<a title="Spomeni na Buzzu" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Podjeli na Buzzu" class="share_buzz socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "digg"; ?>
		<a title="Podijeli na Diggu" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Podijeli na Diggu" class="share_digg socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "stumbleupon"; ?>
		<a title="Podijeli na Stumbleuponu" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Podijeli na Stumbleuponu" class="share_stumbleupon socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "delicious"; ?>
		<a title="Spremi na Delicious" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Spremi na Delicious" class="share_delicious socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "google"; ?>
		<a title="Spremi na Google" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Spremi na Google" class="share_google socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "myspace"; ?>
		<a title="Podijeli na MySpaceu" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Podijeli na MySpaceu" class="share_myspace socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
	 <li>
	 	<? $shareQueryString["s"] = "friendfeed"; ?>
		<a title="Podijeli na Friendfeedu" href="<?= site_url("shared/socshare?" . http_build_query($shareQueryString)); ?>" target="_blank">
			<img alt="Podijeli na Friendfeedu" class="share_friendfeed socialshare" src="<?= static_url("img/transparent.gif"); ?>" />
		</a>
	 </li>
</ul>

<h2>Autorova djela:</h2>