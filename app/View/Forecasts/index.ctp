<div class="forecasts index">
<h2><?php echo __('Forecasts');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('group_id');?></th>
	<th>Starts 1800 UTC on <?php echo $this->Paginator->sort('day');?></th>
	<th><?php echo $this->Paginator->sort('min_temp');?>°C</th>
	<th><?php echo $this->Paginator->sort('max_temp');?>°C</th>
	<th><?php echo $this->Paginator->sort('total_rainfall');?>mm</th>
	<th><?php echo $this->Paginator->sort('wind_direction');?>°</th>
	<th><?php echo $this->Paginator->sort('wind_speed');?>ms<sup><small>-1</small></sup></th>
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
			<?php echo $this->Html->link($forecast['Group']['name'], array('controller' => 'groups', 'action' => 'view', $forecast['Group']['id'])); ?>
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
			<?php echo (($forecast['Forecast']['wind_direction'] +360)%360); ?>
		</td>
		<td>
			<?php echo $forecast['Forecast']['wind_speed']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add Forecast'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Group Summary'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
	</ul>
</div>
