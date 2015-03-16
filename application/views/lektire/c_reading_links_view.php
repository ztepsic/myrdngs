<? if(count($book->GetReadings()) > 0): ?>
<h2>Lektire za download:</h2>
<ul id="readings">
<? foreach ($book->GetReadings() as $key => $reading): ?>
	<li>
		<?
		$title = $book->GetAuthor()->GetFullName();
		if(!empty($title)){
			$title .= " - ";
		}
		
		$title .= $book->GetTitle();
		
		?>
		<?= $key + 1; ?>. <a href="<?= base_url(); ?>lektire/download/<?= $reading->GetId(); ?>/<?= $reading->GetFileName(); ?>" title="<?= $title  . " - " . $reading->GetFileName(); ?>">
			<?= $title; ?>
		</a><br />
		<small><b>Preuzeto:</b> <?= $reading->GetDownloadCount(); ?> puta.</small>
		<?
			$readingAuthor = $reading->GetReadingAuthorName(); 
			if(!empty($readingAuthor)):
				$url = $reading->GetReadingAuthorWebsite(); 
				$author = !empty($url) ? '<a href="' . $url . '" title="'. $reading->GetReadingAuthorName() . '" >' . $reading->GetReadingAuthorName() . '</a>' : $reading->GetReadingAuthorName();
				$authorInfo = $reading->GetReadingAuthorInfo();	
				$author = !empty($author) ? $author . ", " . $reading->GetReadingAuthorInfo() : $author;
		?>
		<small><b>Napisao:</b> <?= $author; ?> (<?= date("Y", $reading->GetDateTimeAdded()); ?>).</small>
		<? endif; ?>
	</li>
<? endforeach; ?>
<? endif; ?>
</ul>

<? if(isset($ad)): ?>
<div class="center" style="margin: 10px 0;">
	<?= $ad; ?>
</div>
<? endif; ?>

<? if(count($book->GetReadingLinks()) > 0): ?>

<h2>Online lektire:</h2>
<ul id="reading-links">
<? foreach ($book->GetReadingLinks() as $key => $readingLink): ?>
	<li>
		<?php
		
			$title = $book->GetAuthor()->GetFullName();
			if(!empty($title)){
				$title .= " - ";
			}
			
			$title .= $book->GetTitle();
			
			$url = site_url("lektire/poveznica/");
			$url .= "/" . $readingLink->GetId() . "/";
			$url .= hr_url_title($book->GetAuthor()->GetFullName() . " " . $book->GetTitle());
			$url .= "--" . hr_url_title($readingLink->GetHost());
			$linkTitle = $title . " @" . $readingLink->GetHost();
		?>
		<?= $key + 1; ?>. <a href="<?= $url ?>" title="<?= $linkTitle; ?>" target="_blank">
			<?= $linkTitle; ?>
		</a>
	</li>
<? endforeach; ?>
<? endif; ?>
</ul>