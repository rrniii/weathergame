<div class="forecasts form">
<?php echo $this->Form->create('Forecast');?>
	<fieldset>
 		<legend><?php echo __('Edit Forecast for '.date('l, jS F Y', strtotime($this->data['Forecast']['day']) + 86400));?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('group_id');
      echo $this->element('forecast_form');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Forecast.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Forecast.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Forecasts'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
