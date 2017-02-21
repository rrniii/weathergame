<div class="groupsindex">
<h2><?php echo __('Groups');?></h2>
<?php
foreach ($groups as $group):
?>
	<div class="group">
		<h4>
			<?php echo $this->Html->link($group['Group']['name'],array('controller' => 'groups', 'action' => 'edit', $group['Group']['id'])); ?>
		</h4>
		<p><ul>
		<?php foreach($group['Forecast'] as $forecast)
			{
				if(isset($forecast['total_points']))
				{
					echo '<li>'.$this->Html->link($forecast['day'],array('controller' => 'forecasts','action' => 'show_points',$forecast['day'])).': '.$forecast['total_points'].'</li>';
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
		<li><?php echo $this->Html->link(__('List Forecasts'), array('controller' => 'forecasts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add Forecast'), array('controller' => 'forecasts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Today\'s predictions'), array('controller' => 'forecasts', 'action' => 'today')); ?> </li>
	</ul>
</div>