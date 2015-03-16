<ul id="breadcrumbs">
	<li><a href="<?= $homeElementAnchor->GetUri(); ?>"><?= $homeElementAnchor->GetTitle(); ?></a></li>
	<? foreach($middleElements as $middleElementAnchor): ?>
	<li><a href="<?= $middleElementAnchor->GetUri(); ?>"><?= $middleElementAnchor->GetTitle(); ?></a></li>
	<? endforeach; ?>
	<li><?= $lastElement ?></li>
</ul>
<div class="clear"></div>
