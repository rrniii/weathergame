<div class="groupsindex">
<h2><?php __('Groups');?></h2>
<?php
foreach ($groups as $group):
?>
	<div class="group">
		<h4>
			<?php echo $group['Group']['name']; ?>
		</h4>
		<p><ul>
		<?php foreach($group['Forecast'] as $forecast)
			{
				if(isset($forecast['total_points']))
				{
					echo '<li>'.$html->link($forecast['day'],array('controller' => 'forecasts','action' => 'show_points',$forecast['day'])).': '.$forecast['total_points'].'</li>';
				}
			}
		?></ul>
		</p>
		<h5>Total points: <?php echo array_sum(Set::extract('/Forecast/total_points',$group)); ?>
		</h5>
	</div>
<?php endforeach; ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Forecasts', true), array('controller' => 'forecasts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Add Forecast', true), array('controller' => 'forecasts', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Today\'s predictions', true), array('controller' => 'forecasts', 'action' => 'today')); ?> </li>
	</ul>
</div>
