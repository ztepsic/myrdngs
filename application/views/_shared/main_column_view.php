<div id="title">
	<?= isset($mainTitle) ? "<h1>" . $mainTitle . "</h1>" : "" ?>
</div>

<? if(isset($url)): ?>
	<div style="position: absolute; right: 0;">
		<div style="top: -30px; position: relative; z-index: 9999;">
			<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
			<g:plusone lang="hr" size="small" count="true" href=""></g:plusone>
		</div>
		<div style="top: -15px; position: relative; z-index: 9999;">
			<iframe src="http://www.facebook.com/plugins/like.php?app_id=206030906099655&amp;locale=hr_HR&amp;href=<?= $url; ?>&amp;send=false&amp;layout=button_count&amp;show_faces=false&amp;width=130&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe>
		</div>
	</div>
	<div class="clear"></div>
	<? endif; ?>

<?= isset($mainContent) ? $mainContent : "" ?>