<div class="forecasts form">
<?php echo $this->Form->create('Forecast');?>
	<fieldset>
 		<legend><?php echo __('Add Forecast for '.Forecast::next_forecast('human_readable')); ?></legend>
	<?php
		echo $this->Form->input('group_id');
      echo $this->element('forecast_form');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Forecasts'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
