<ul class="entries">
<? foreach ($books as $book): ?>

    <li class="entry">
		<h2 class="entry-title book">
			<a href="<?= base_url(); ?>lektira/<?= $book->GetId(); ?>/<?= hr_url_title($book->GetTitle(), "dash", true); ?>" title="<?= $book->GetTitle(); ?>">
				<?= $book->GetTitle(); ?>
			</a>
		</h2>

        <ul class="entry-meta">
        	<li>
                Pisac:
				<a href="<?= base_url(); ?>pisac/<?= $book->GetAuthor()->GetId(); ?>/<?= hr_url_title($book->GetAuthor()->GetFullName(), "dash", true); ?>" title="<?= $book->GetAuthor()->GetFullName(); ?>">
					<?= $book->GetAuthor()->GetFullName(); ?>
				</a>
            </li>
            <li>
            	Lektire za download: <?= count($book->GetReadings()); ?>
            </li>
			<li>
            	Online lektire: <?= count($book->GetReadingLinks()); ?>
            </li>
        </ul> <!-- .entry-meta -->

        <? if($book->GetDescription() != null): ?>
		<blockquote class="entry-content">
		 	<?= word_limiter(strip_tags($book->GetDescription()), 50); ?>
		</blockquote> <!-- .entry-content -->
		<? endif; ?>
 	</li> <!-- entry -->
<? endforeach; ?>
</ul>

<? if(isset($pagination)): ?>
<?= $pagination; ?>
<? endif; ?>