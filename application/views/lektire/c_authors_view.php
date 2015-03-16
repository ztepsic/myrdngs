<ul class="entries">
<? foreach ($authors as $author): ?>
    <li class="entry">
		<h2 class="entry-title author">
			<a href="<?= base_url(); ?>pisac/<?= $author->GetId(); ?>/<?= hr_url_title($author->GetFullName(), "dash", true); ?>" title="<?= $author->GetFullName(); ?>">
				<?= $author->GetFullName(); ?>
			</a>
		</h2>
		
		<ul class="entry-meta">
        	<li>
        	<?
        	$authorBooks = $this->booksModel->GetBooksByAuthor($author->GetId());
			$authorBooksCount = count($authorBooks);
        	?>
            	Dostupno autorovih djela: <?= $authorBooksCount; ?>
            </li>
        </ul> <!-- .entry-meta -->
		
		<? if($author->GetInfo() != null): ?>
		<blockquote class="entry-content">
		 	<?= word_limiter(strip_tags($author->GetInfo()), 50); ?>
		</blockquote> <!-- .entry-content -->
		<? endif; ?>
 	</li> <!-- entry -->
<? endforeach; ?>
</ul>

<? if(isset($pagination)): ?>
<?= $pagination; ?>
<? endif; ?>
