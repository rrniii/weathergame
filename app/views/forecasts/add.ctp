<div class="forecasts form">
<?php echo $form->create('Forecast');?>
	<fieldset>
 		<legend><?php __('Add Forecast for '.Forecast::next_forecast('human_readable')); ?></legend>
	<?php
		echo $form->input('group_id');
		echo $form->input('min_temp',array('after' => '°C, to nearest 0.1°'));
		echo $form->input('max_temp', array('after' => '°C, to nearest 0.1°'));
		echo $form->input('total_rainfall', array('after' => 'mm, to nearest whole mm'));
		echo $form->input('wind_direction', array('after' => '° at 1200UTC (0-359)'));
		echo $form->input('wind_speed', array('after' => 'ms<sup><small>-1</small></sup> at 1200UTC to nearest 1ms<sup><small>-1</small></sup>'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Forecasts', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
