<div class="nodes promoted">
    <?php
        if (count($nodes) == 0) {
            __('No items found.');
        } else {
            foreach ($this->params['named'] AS $nn => $nv) {
                $paginator->options['url'][$nn] = $nv;
            }
        }
    ?>

    <?php 
        foreach ($nodes AS $node) {
            $layout->setNode($node);
    ?>
    <div id="node-<?php echo $layout->node('id'); ?>" class="node node-type-<?php echo $layout->node('type'); ?>">
    <!-- blog item -->
		<div class="blogItem">
        <div class="itemTitle clearfix">
					<div class="date">
						<span class="month">Month</span><br />
						<span class="day">Day</span>

					</div>
					<h1><?php echo $html->link($layout->node('title'), $layout->node('url')); ?></h1>
				</div>
    </div>			
		<!-- end blogItem -->

        <?php
            echo $layout->nodeInfo();
            echo $layout->nodeBody();
            echo $layout->nodeMoreInfo();
        ?>
        
        <br />
        <hr size="1" />
        <br />
    </div>
    <?php 
        }
    ?>

    <div class="paging"><?php echo $paginator->numbers(); ?></div>
</div>
