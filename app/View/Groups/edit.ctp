<div class="groups form">
<?php echo $this->Form->create('Group');?>
	<fieldset>
 		<legend><?php echo __('Edit Group');?> <?php echo $this->request->data['Group']['name']; ?></legend>
	<?php
		echo $this->Form->input('id');
      echo $this->Form->input('hydrostatic_height',array('after' => 'm'));
      echo $this->Form->input('gps_height', array('after' => 'm','label' => 'GPS Height'));
      echo $this->Form->input('theodolite_height',array('after' => 'm'));
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Group.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Group.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Forecasts'), array('controller' => 'forecasts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Forecast'), array('controller' => 'forecasts', 'action' => 'add')); ?> </li>
	</ul>
</div>
