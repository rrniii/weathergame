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
	<th>Starts 1800 on <?php echo $paginator->sort('day');?></th>
	<th><?php echo $paginator->sort('min_temp');?>°C</th>
	<th><?php echo $paginator->sort('max_temp');?>°C</th>
	<th><?php echo $paginator->sort('total_rainfall');?>mm</th>
	<th><?php echo $paginator->sort('wind_direction');?>°</th>
	<th><?php echo $paginator->sort('wind_speed');?>ms<sup><small>-1</small></sup></th>
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
		<li><?php echo $html->link(__('Add Forecast', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('Group Summary', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
	</ul>
</div>
