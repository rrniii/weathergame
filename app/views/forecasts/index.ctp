<div class="forecasts index">
<h2><?php __('Forecasts');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('group_id');?></th>
	<th><?php echo $paginator->sort('day');?></th>
	<th><?php echo $paginator->sort('min_temp');?>°C</th>
	<th><?php echo $paginator->sort('max_temp');?>°C</th>
	<th><?php echo $paginator->sort('total_rainfall');?>mm</th>
	<th><?php echo $paginator->sort('wind_direction');?>°</th>
	<th><?php echo $paginator->sort('wind_speed');?>ms<sup><small>-1</small></sup></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($forecasts as $forecast):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($forecast['Group']['name'], array('controller' => 'groups', 'action' => 'view', $forecast['Group']['id'])); ?>
		</td>
		<td>
			<?php echo $forecast['Forecast']['day']; ?>
		</td>
		<td>
			<?php echo $forecast['Forecast']['min_temp']; ?>
		</td>
		<td>
			<?php echo $forecast['Forecast']['max_temp']; ?>
		</td>
		<td>
			<?php echo $forecast['Forecast']['total_rainfall']; ?>
		</td>
		<td>
			<?php echo $forecast['Forecast']['wind_direction']; ?>
		</td>
		<td>
			<?php echo $forecast['Forecast']['wind_speed']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $forecast['Forecast']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $forecast['Forecast']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $forecast['Forecast']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $forecast['Forecast']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Forecast', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
