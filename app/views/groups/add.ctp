<div class="groups form">
<?php echo $form->create('Group');?>
	<fieldset>
 		<legend><?php __('Add Group');?></legend>
	<?php
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Groups', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Forecasts', true), array('controller' => 'forecasts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Forecast', true), array('controller' => 'forecasts', 'action' => 'add')); ?> </li>
	</ul>
</div>
