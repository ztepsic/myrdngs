<ul class="entries">
<? foreach ($ztRssChannelItems as $key => $ztRssChannelItem): ?>
<? 
	$parsedUrlArray = parse_url(($ztRssChannelItem->GetGuid()));
	$host = isset($parsedUrlArray["host"]) ? $parsedUrlArray["host"] : "";
?>
    <li class="entry">    	
    	<div>
    		<h2 class="entry-title">
    			<a href="<?= site_url("webcafe/clanak/" . $ztRssChannelItem->GetId() . "/" . hr_url_title($ztRssChannelItem->GetTitle()) . "--" . hr_url_title($host)); ?>" target="_blank"><?= $ztRssChannelItem->GetTitle(); ?></a>
    		</h2>

	        <dl class="meta">
	            
	            <dt>
	                Objavio:
	            </dt>
	            <dd>
	            	<a href="http://<?= $host ?>"><?= $host ?></a>
	            </dd>
	            
	            <dt>
	                Datum:
	            </dt>
	            <dd>
	                <?= date("H:i, d-m-Y", $ztRssChannelItem->GetPubDate()); ?>
	            </dd>
	            
	        </dl> <!-- .meta -->

        	<blockquote class="entry-content">
        			<? if($ztRssChannelItem->GetImage() != null):?>
    					<a href="<?= site_url("webcafe/clanak/" . $ztRssChannelItem->GetId() . "/" . hr_url_title($ztRssChannelItem->GetTitle()) . "--" . hr_url_title($host)); ?>" target="_blank">
    						<?
									$image = $ztRssChannelItem->GetImage();
									if(!empty($image)):
								?>
									<img  class="thumbnail float-left" src="<?= htmlentities($image); ?>" alt="<?= htmlentities($ztRssChannelItem->GetTitle()); ?>"/>
								<? endif;?>
    					</a>
    				<? endif; ?>
						<?= $ztRssChannelItem->GetDescription(); ?>
						<small>
		        	<a href="<?= site_url("webcafe/clanak/" . $ztRssChannelItem->GetId() . "/" . hr_url_title($ztRssChannelItem->GetTitle()) . "--" . hr_url_title($host)); ?>" target="_blank">Opširnije</a>
        		</small>
        	</blockquote> <!-- .entry-content -->
        	
        
        	
		
    </div> <!-- .entry -->
    <div class="clear"></div>
  </li>
 <? endforeach; ?>
</ul>

<?= $pagination; ?>