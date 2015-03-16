<?php

// #################################
// ###### GENERAL ##### BEGIN ######
// #################################

$config["zt_static_urls"] = array(
	"http://localhost/mojelektire/source/"
);

/*$config["zt_static_urls"] = array(
	array(
		"extensions"  => "js",
		"host" => "http://static.moje-lektire.com/com.moje-lektire/JS/"
	),
	array(
		"extensions"  => "gif|jpeg|jpg|png|css",
		"host" => "http://static.moje-lektire.com/com.moje-lektire/IMG/"
	)
);*/

$config["zt_site_enabled"] = true;
$config["zt_site_disabled_title"] = "Stranica trenutno nije dostupna.";
$config["zt_site_disabled_msg"] = "Stranica trenutno nije dostupna. Molimo Vas da budete strpljivi i pokušajte kroz par sati ponovno.";

$config["zt_site_title"] = "Moje lektire";
$config["zt_site_slogan"] = "Lektire za osnovnu i srednju školu";
$config["zt_site_description"] = "Zbirka lektira za osnovne i srednje škole.";
$config["zt_site_keywords"] = "lektire, knjige, pisci, lektira, srednja, srednju, osnovna, osnovnu, škola, školu, download";
$config["zt_site_lang"] = "hr";
$config["zt_site_since"] = "2009-08-04";

$config["zt_pagination_querystring"] = false;

$config["zt_google_analytics"] = "
<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12500350-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

";

// ###############################
// ###### GENERAL ##### END ######
// ###############################

// ##############################
// ###### HEAD ##### BEGIN ######
// ##############################


$config["zt_head_meta"] = array(
	array("name" => "Content-type", "content" => "text/html; charset=utf-8", "type" => "http-equiv"),
	array("name" => "Content-Language", "content" => $config['zt_site_lang'], "type" => "http-equiv"),
	
);


$config["zt_head_links"] = array(
	array("href" => "css/960gs/reset.css", "media" => "all", "rel" => "stylesheet", "type" => "text/css"),
	array("href" => "css/960gs/text.css", "media" => "all", "rel" => "stylesheet", "type" => "text/css"),
	array("href" => "css/960gs/960.css", "media" => "all", "rel" => "stylesheet", "type" => "text/css"),
	array("href" => "css/style.css", "media" => "all", "rel" => "stylesheet", "type" => "text/css"),
	array("href" => "favicon.ico",  "rel" => "Shortcut Icon",  "type" => "image/x-icon")
);


$config["zt_head_scripts"] = array(
	array("src" => "js/jquery/jquery-1.4.2.min.js"),
	array("src" => "js/jfav/jFav_v1.0.js")
);



// ############################
// ###### HEAD ##### END ######
// ############################

// ####################################
// ###### PAGINATION ##### BEGIN ######
// ####################################

$config["zt_pagination"] = array(
		'full_tag_open' => '<ul class="pagination">',
		'full_tag_close' => '</ul>',
		'first_link' => 'Prva',
		'first_tag_open' => '<li>',
		'first_tag_close' => '</li>',
		'last_link' => 'Posljednja',
		'last_tag_open' => '<li>',
		'last_tag_close' => '</li>',
		'next_link' => 'Sljedeća &rsaquo;',
		'next_tag_open' => '<li>',
		'next_tag_close' => '</li>',
		'prev_link' => '&lsaquo; Prethodna',
		'prev_tag_open' => '<li>',
		'prev_tag_close' => '</li>',
		'cur_tag_open' => '<li class="current">',
		'cur_tag_close' => '</li>',
		'num_tag_open' => '<li>',
		'num_tag_close' => '</li>'
);

// ##################################
// ###### PAGINATION ##### END ######
// ##################################

