<?php $layout->setNode($node); ?>
<div id="node-<?php echo $layout->node('id'); ?>" class="node node-type-<?php echo $layout->node('type'); ?>">

    <!-- blog item -->
		<div class="blogItem">
        <div class="itemTitle clearfix">
					<div class="date">
						<span class="month">Month</span><br />
						<span class="day">Day</span>

					</div>
					<h1><?php echo $layout->node('title'); ?></h1>
				</div>
    </div>			
		<!-- end blogItem -->

    <p>
    <?php
        echo $layout->nodeInfo();
        echo $layout->nodeBody();
        echo $layout->nodeMoreInfo();
    ?>
    </p>
</div>

<div id="comments" class="node-comments">
<?php
    $type = $types_for_layout[$layout->node('type')];

    if ($type['Type']['comment_status'] > 0 && $layout->node('comment_status') > 0) {
        echo '<p>'.$this->element('comments').'</p>';
    }

    if ($type['Type']['comment_status'] == 2 && $layout->node('comment_status') == 2) {
        echo '<div id="respond"><p>'.$this->element('comments_form').'</p></div>';
    }
?>
</div>
