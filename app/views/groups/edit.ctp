<div class="groups form">
<?php echo $form->create('Group');?>
	<fieldset>
 		<legend><?php __('Edit Group');?> <?php echo $this->data['Group']['name']; ?></legend>
	<?php
		echo $form->input('id');
      echo $form->input('hydrostatic_height',array('after' => 'm'));
      echo $form->input('gps_height', array('after' => 'm','label' => 'GPS Height'));
      echo $form->input('theodolite_height',array('after' => 'm'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Group.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Group.id'))); ?></li>
		<li><?php echo $html->link(__('List Groups', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Forecasts', true), array('controller' => 'forecasts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Forecast', true), array('controller' => 'forecasts', 'action' => 'add')); ?> </li>
	</ul>
</div>
