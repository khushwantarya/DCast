<div class="questions index">
    <h2><?php echo $title_for_layout; ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Question', true), array('action'=>'add', 'event_id' => $event_id)); ?></li>
        </ul>
    </div>
	
	<?php echo $this->Form->create('Catgory', array('url' => array('controller' => 'questions', 'action' => 'process', 'event_id' => $event_id))); ?>
    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders =  $this->Html->tableHeaders(array(
			'',
            $paginator->sort('id'),
            $paginator->sort('title'),
			$paginator->sort('keyword'),
			$paginator->sort('status'),
            __('Actions', true),
        ));
        echo $tableHeaders;

        $rows = array();
        foreach ($questions as $question) {
            $actions  = $this->Html->link(__('Edit', true), array('controller' => 'questions', 'action' => 'edit', 'event_id' => $event_id, $question['Question']['id']));
            $actions .= ' ' . $this->Layout->adminRowActions($question['Question']['id']);
            $actions .= ' ' . $this->Html->link(__('Delete', true), array(
                'controller' => 'questions',
                'action' => 'delete',
				'event_id' => $event_id,
                $question['Question']['id'],
                'token' => $this->params['_Token']['key'],
            ), null, __('Are you sure?', true));

            $rows[] = array(
				$this->Form->checkbox('Question.'.$question['Question']['id'].'.id'),
                $question['Question']['id'],
				$question['Question']['title'],
                $question['Question']['keyword'],			
				$question['Question']['status'],
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    ?>
    </table>
    <div class="bulk-actions">
    <?php
        echo $this->Form->input('Question.action', array(
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
