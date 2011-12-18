<div class="avatars index">
    <h2><?php echo $title_for_layout; ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Avatar', true), array('action'=>'add')); ?></li>
        </ul>
    </div>
	
	<?php echo $this->Form->create('Catgory', array('url' => array('controller' => 'avatars', 'action' => 'process'))); ?>
    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders =  $this->Html->tableHeaders(array(
			'',
            $paginator->sort('id'),
            $paginator->sort('title'),
			$paginator->sort('desc'),
			__('Image', true),
			$paginator->sort('status'),
            __('Actions', true),
        ));
        echo $tableHeaders;

        $rows = array();
        foreach ($avatars as $avatar) {
            $actions  = $this->Html->link(__('Edit', true), array('controller' => 'avatars', 'action' => 'edit', $avatar['Avatar']['id']));
            $actions .= ' ' . $this->Layout->adminRowActions($avatar['Avatar']['id']);
            $actions .= ' ' . $this->Html->link(__('Delete', true), array(
                'controller' => 'avatars',
                'action' => 'delete',
                $avatar['Avatar']['id'],
                'token' => $this->params['_Token']['key'],
            ), null, __('Are you sure?', true));

            $rows[] = array(
				$this->Form->checkbox('Avatar.'.$avatar['Avatar']['id'].'.id'),
                $avatar['Avatar']['id'],
				$avatar['Avatar']['title'],
                $avatar['Avatar']['desc'],
				$this->Html->image(Configure::read('CV.avatar_browse_path') . $avatar["Avatar"]["image"], array("alt" => "", "width" => "50")),	
							
				$avatar['Avatar']['status'],
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    ?>
    </table>
    <div class="bulk-actions">
    <?php
        echo $this->Form->input('Avatar.action', array(
            'label' => false,
            'options' => array(
                'publish' => __('Publish', true),
                'unpublish' => __('Unpublish', true),
                'delete' => __('Delete', true)
            ),
            'empty' => 'Select action',
        ));
        echo $this->Form->end(__('Submit', true));
    ?>
    </div>
</div>

<div class="paging"><?php echo $paginator->numbers(); ?></div>
<div class="counter"><?php echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></div>
