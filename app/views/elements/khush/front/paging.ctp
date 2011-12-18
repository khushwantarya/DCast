<?php
if (!isset($paginator->params['paging'])) {
  return;
}

if (!isset($model) || $paginator->params['paging'][$model]['pageCount'] < 2) {
  return;
}
if (!isset($options)) {
  $options = array();
}

$options['model'] = $model;
$options['url']['model'] = $model;
$paginator->__defaultModel = $model;

if (isset($community)) {
  $options['url'][] = $community['Community']['id'];
} elseif (isset($user)) {
  $options['url'][] = $user['User']['id'];
}
?>
<div id="pagination" class="datapager">
	<?php
	$paginator->options(array('url' => array($to_pass . "/tab:livestream", "model" => $model), 'update' => '#livestream_container', 'model' => $model));
	$paginator->prev(__('Previous',true), array('class' => 'pagerbtn'),null,array('class' => 'previous-off')) . "&nbsp; &nbsp;" .
	$paginator->numbers(array("separator"=>'&nbsp;&nbsp;', 'class' => 'pager', 'url' => array($to_pass . "/tab:livestream", "model" => $model), 'model' => $model)) . "&nbsp; &nbsp;" .
	$paginator->next(__('Next',true),array('class' => 'pagerbtn'),null,array('class' => 'next-off'));  
	?>
	<div class="clear"></div>
</div>	

<!-- 
<div class="paging">
  <?php
  //echo $paginator->prev('<< Previous', array_merge(array('escape' => false, 'class' => 'prev'), $options), null, array('class' => 'disabled'));
  //echo $paginator->numbers(am($options, array('before' => false, 'after' => false, 'separator' => false)));
 // echo $paginator->next('Next >>', array_merge(array('escape' => false, 'class' => 'next'), $options), null, array('class' => 'disabled'));
  ?>
</div>
-->
