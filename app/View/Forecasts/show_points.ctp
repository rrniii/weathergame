<h3>Points for <?php echo $day; ?></h3>
<table><tbody><tr><th>Group</th><th>Min Temp / °C</th><th>Max Temp / °C</th><th>Total Rainfall / mm</th><th>Wind Direction / °</th><th>Wind speed / ms<sup><small>-1</small></sup></th><th>Points</th></tr><?php
	foreach($forecasts as $forecast)
	{
		echo'<tr><td>'.$forecast['Group']['name'].'</td>'; 
		echo(	'<td class="'.Forecast::points_words($forecast['Forecast']['min_temp_points']).'">'.$forecast['Forecast']['min_temp'].'<div class="points">('.$forecast['Forecast']['min_temp_points'].' pts)</div></td>'.
			'<td class="'.Forecast::points_words($forecast['Forecast']['max_temp_points']).'">'.$forecast['Forecast']['max_temp'].'<div class="points">('.$forecast['Forecast']['max_temp_points'].' pts)</div></td>'.
			'<td class="'.Forecast::points_words($forecast['Forecast']['total_rainfall_points']).'">'.$forecast['Forecast']['total_rainfall'].'<div class="points">('.$forecast['Forecast']['total_rainfall_points'].' pts)</div></td>'.
			'<td class="'.Forecast::points_words($forecast['Forecast']['wind_direction_points']).'">'.$forecast['Forecast']['wind_direction'].'<div class="points">('.$forecast['Forecast']['wind_direction_points'].' pts)</div></td>'.
			'<td class="'.Forecast::points_words($forecast['Forecast']['wind_speed_points']).'">'.$forecast['Forecast']['wind_speed'].'<div class="points">('.$forecast['Forecast']['wind_speed_points'].' pts)</div></td>');
		echo(	'<td>'.$forecast['Forecast']['total_points'].'</td>');
			#pr($forecast);
		#pr($forecast);
		echo'</td></tr>';
	}
?></tbody></table>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Group Summary'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
	</ul>
</div>
