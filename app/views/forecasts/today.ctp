<h3>Predictions for <?php echo Forecast::next_forecast('human_readable'); ?></h3>
<table><tbody><tr><th>Group</th><th>Min Temp / °C</th><th>Max Temp / °C</th><th>Total Rainfall / mm</th><th>Wind Direction / °</th><th>Wind speed / ms<sup><small>-1</small></sup></th></tr><?php
	foreach($groups as $group)
	{
		echo'<tr><td>'.$group['Group']['name'].'</td>'; 
		$forecast = (Set::extract('/Forecast[day='.date('Y-m-d',Forecast::next_forecast('start')).']', $group));
		if(count($forecast) > 0)
		{
			echo('<td>'.$forecast[0]['Forecast']['min_temp'].'</td><td>'.$forecast[0]['Forecast']['max_temp'].'</td><td>'.$forecast[0]['Forecast']['total_rainfall'].'</td><td>'.$forecast[0]['Forecast']['wind_direction'].'</td><td>'.$forecast[0]['Forecast']['wind_speed'].'</td>');
			#pr($forecast);
		}
		else
		{
			echo '<td colspan="5" class="missing">NOT YET ENTERED</td>'; 
		}
		#pr($group);
		echo'</td></tr>';
	}
?></tbody></table>
