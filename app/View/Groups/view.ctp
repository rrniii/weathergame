<div class="groups view">
<h2><?php echo __('Group');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Group'), array('action' => 'edit', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Group'), array('action' => 'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Forecasts'), array('controller' => 'forecasts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Forecast'), array('controller' => 'forecasts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Forecasts');?></h3>
	<?php if (!empty($group['Forecast'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Day'); ?></th>
		<th><?php echo __('Min Temp'); ?></th>
		<th><?php echo __('Max Temp'); ?></th>
		<th><?php echo __('Total Rainfall'); ?></th>
		<th><?php echo __('Wind Direction'); ?></th>
		<th><?php echo __('Wind Speed'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($group['Forecast'] as $forecast):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $forecast['id'];?></td>
			<td><?php echo $forecast['group_id'];?></td>
			<td><?php echo $forecast['day'];?></td>
			<td><?php echo $forecast['min_temp'];?></td>
			<td><?php echo $forecast['max_temp'];?></td>
			<td><?php echo $forecast['total_rainfall'];?></td>
			<td><?php echo $forecast['wind_direction'];?></td>
			<td><?php echo $forecast['wind_speed'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Forecast'), array('controller' => 'forecasts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
