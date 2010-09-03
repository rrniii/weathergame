<div class="forecasts form">
<?php echo $form->create('Forecast');?>
	<fieldset>
 		<legend><?php __('Edit Forecast for '.date('l, jS F Y', strtotime('tomorrow')));?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('group_id');
		echo $form->input('min_temp');
		echo $form->input('max_temp');
		echo $form->input('total_rainfall');
		echo $form->input('wind_direction');
		echo $form->input('wind_speed');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Forecast.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Forecast.id'))); ?></li>
		<li><?php echo $html->link(__('List Forecasts', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
