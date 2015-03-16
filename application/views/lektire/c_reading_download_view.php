<dl class="meta">
	<dt>
		Datoteka:
	</dt>
	<dd>
		<?= $reading->GetFileName(); ?>
	</dd>
	<dt>
		Lektira:
	</dt>
	<dd>
		<?
			$url = site_url("lektira/" . $book->GetId() . "/" . hr_url_title($book->GetTitle()));
			$linkTitle = $book->GetTitle() . " - " . $book->GetAuthor()->GetFullName();
		?>
		<a href="<?= $url ?>" title="Lektira - <?= $linkTitle; ?>">
			<?= $linkTitle; ?>
		</a>
	</dd>
</dl>
<br />

<?= $ads; ?>

<br /><br />

<div id="ad" class="center">
	<p style="font-size: 1.2em;"><b>Pripremanje datoteke za download. Pričekajte trenutak ...</b></p>
	<?= $largeRectangleAd; ?>
</div>

<div id="ff" style="display: none;" class="center">
	<a rel="nofollow" href="<?= base_url(); ?>lektire/datoteka/<?= $reading->GetId(); ?>/<?= $reading->GetFileName(); ?>" title="<?= $reading->GetFileName(); ?>">
		<img src="<?= static_url("img/download.jpg"); ?>" alt="Download"/>
	</a>
</div>

