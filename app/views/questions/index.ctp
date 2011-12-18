<?php echo $this->element('khush/right', array("heading" => "")); ?>
<div class="in_content">
	<h2>Testimonials</h2>
	
	<div class="property_lsting">
		<?php if(!empty($data_array)) { ?>
			<h3>
			<?php //echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?> 
			<?php echo $paginator->counter(array('format' => __('%count% Testimonials found', true))); ?> 
			</h3>
			<ul>
			
				<?php foreach($data_array as $k => $v) { ?>
				<li>
					<div style="width: 100%;">
						<p class="desc"><?php echo nl2br($v["Testimonial"]["comment"]); ?></p>
						<p class="contact_details">
							By : <?php echo $v["Testimonial"]["name"]; ?>  <br  />
							<?php if($v["Testimonial"]["name"] != "")  { ?>
							Email : <?php echo $v["Testimonial"]["email"]; ?> <br />
							<?php } ?>
							Posted: <?php echo date("F d, Y", strtotime($v["Testimonial"]["created"])); ?>
						</p>
				</li>
				<?php } ?>
			</ul>
		<?php } else { ?>
			<h3>No Testimonial Found</h3>
		<?php } ?>
		<div class="clr"></div>
	</div>
	
	<div class="Paging">
		<ul>
			<li><?php echo $paginator->prev(); ?></li>
			<?php echo $paginator->numbers(array("tag" => "li", "separator" => "")); ?>
			<li><?php echo $paginator->next(); ?></li>							
		</ul>
	</div>
</div>


<script>
	$(document).ready(function(){
		$(".view_contact_detail").click(function(){
			$("#" + $(this).attr("id") + "_target").show("slow");
		});
		
		$(".close").click(function(){
			$(this).parent().hide("slow");
		});
	});
</script>
