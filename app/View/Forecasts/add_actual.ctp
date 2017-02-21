<div class="forecasts form">
<?php echo $this->Form->create('Forecast');?>
	<fieldset>
 		<legend><?php echo __('Add Readings'); ?></legend>
	<?php
		echo $this->Form->input('group_id',array('type'=>'hidden','value' => 10)); #Actual group
		echo $this->Form->input('day',array('label' => 'Starts at 18:00 on'));
		echo $this->Form->input('min_temp',array('after' => '°C, to nearest 0.1°'));
		echo $this->Form->input('max_temp', array('after' => '°C, to nearest 0.1°'));
		echo $this->Form->input('total_rainfall', array('after' => 'mm, to nearest whole mm'));
		echo $this->Form->input('wind_direction', array('after' => '° at 1200UTC (0-359)'));
		echo $this->Form->input('wind_speed', array('after' => 'ms<sup><small>-1</small></sup> at 1200UTC to nearest 1ms<sup><small>-1</small></sup>'));
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
