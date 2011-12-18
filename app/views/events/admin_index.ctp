<div class="events index">
    <h2><?php echo $title_for_layout; ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Event', true), array('action'=>'add')); ?></li>
        </ul>
    </div>
	
	<?php echo $this->Form->create('Catgory', array('url' => array('controller' => 'events', 'action' => 'process'))); ?>
    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders =  $this->Html->tableHeaders(array(
			'',
            $paginator->sort('id'),
            $paginator->sort('Event Name', 'name'),
			$paginator->sort('Organization', 'organization_name'),
			$paginator->sort('Start Date', 'date_from'),
			$paginator->sort('End Date', 'date_to'),
			$paginator->sort('status'),
            __('Actions', true),
        ));
        echo $tableHeaders;

        $rows = array();
        foreach ($events as $event) {
            $actions  = $this->Html->link(__('View Details', true), array('controller' => 'events', 'action' => 'view', $event['Event']['id']));
			$actions .= '' . $this->Html->link(__('View Questions', true), array('controller' => 'questions', 'action' => 'index', 'event_id' => $event['Event']['id']));
            $actions .= ' ' .$this->Html->link(__('Edit', true), array('controller' => 'events', 'action' => 'edit', $event['Event']['id']));
            $actions .= ' ' . $this->Layout->adminRowActions($event['Event']['id']);
            $actions .= ' ' . $this->Html->link(__('Delete', true), array(
                'controller' => 'events',
                'action' => 'delete',
                $event['Event']['id'],
                'token' => $this->params['_Token']['key'],
            ), null, __('Are you sure?', true));

            $rows[] = array(
				$this->Form->checkbox('Event.'.$event['Event']['id'].'.id'),
                $event['Event']['id'],
				$event['Event']['name'],
                $event['Event']['organization_name'],
                $event['Event']['date_from'],	
				$event['Event']['date_to'],				
				$event['Event']['status'],
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    ?>
    </table>
    <div class="bulk-actions">
    <?php
        echo $this->Form->input('Event.action', array(
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
