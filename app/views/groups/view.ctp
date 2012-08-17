<div class="groups view">
<h2><?php  __('Group');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Group', true), array('action' => 'edit', $group['Group']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Group', true), array('action' => 'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $group['Group']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Groups', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Forecasts', true), array('controller' => 'forecasts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Forecast', true), array('controller' => 'forecasts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Forecasts');?></h3>
	<?php if (!empty($group['Forecast'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Group Id'); ?></th>
		<th><?php __('Day'); ?></th>
		<th><?php __('Min Temp'); ?></th>
		<th><?php __('Max Temp'); ?></th>
		<th><?php __('Total Rainfall'); ?></th>
		<th><?php __('Wind Direction'); ?></th>
		<th><?php __('Wind Speed'); ?></th>
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
			<li><?php echo $html->link(__('New Forecast', true), array('controller' => 'forecasts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
