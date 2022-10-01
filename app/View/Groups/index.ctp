<div class="groupsindex">
<h2><?php echo __('Groups');?></h2>
<?php

$this->Html->scriptBlock('$(document).ready(function(){
    jQuery.fn.sortDivs = function sortDivs() {
        $("> div", this[0]).sort(dec_sort).appendTo(this[0]);
        function dec_sort(a, b){ return ($(b).data("sort")) > ($(a).data("sort")) ? 1 : -1; }
    }
    $(".groupsindex").sortDivs();
});
', array('inline' => False));

foreach ($groups as $group):
   $total_pts = array_sum(Set::extract('/Forecast/total_points',$group));
?>
	<div class="group" data-sort="<?php echo $total_pts; ?>">
		<h4>
			<?php echo $this->Html->link($group['Group']['name'],array('controller' => 'groups', 'action' => 'view', $group['Group']['id'])); ?>
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
		<h5>Total points: <?php echo $total_pts; ?>
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
    <p>Details of the scoring system and deadlines may be found in the handbook.</p>
</div>
