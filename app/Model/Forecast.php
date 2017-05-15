<?php
class Forecast extends AppModel {

	var $name = 'Forecast';
   var $order = 'Forecast.day DESC';

	var $validate = array(
		'min_temp' => array(	'rule' => array('decimal',1),
					'message' => 'Must be numeric, to nearest 0.5°C'
					),
		'max_temp' => array(	'rule' => array('decimal',1),
					'message' => 'Must be numeric, to nearest 0.5°C'
					),
		'total_rainfall' => array (	'ruleOne' => array(
                     'rule' => '/^[0-9]*.[05]/',
					      'message' => 'Must be numeric, to nearest 0.5mm'),
						'ruleTwo' => array(
							'rule'=> array('minlength',1),
							'message' => 'Cannot be left blank',
						),
		),

		'wind_direction' => array( 'rule' => array('range', -1, 360),
						'message' => 'Must be in range 0-359',
					),
		'wind_speed' => array (	'ruleOne' => array(
							'rule' => array('comparison', '>=', 0),
							'message' => 'Must be integer greater than or equal to 0',),
						'ruleTwo' => array(
							'rule'=> array('minlength',1),
							'message' => 'Cannot be left blank',
						),
		),
		'group_id' => array(
			'rule' => array('noDuplicates', array('group_id', 'day')),
            		'message' => 'This combination of day & group is already set',
        		),
		);
		

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function beforeValidate()
	{
		if($this->data['Forecast']['group_id'] != 10)
		{
			$this->data['Forecast']['day'] = date('Y-m-d', Forecast::next_forecast('start'));
		}
		return true;
	}

	function points($forecast)
	{
		#is input of form $forcast['Forecast'][data] or $forecast[data]?
		$flag = 0;
		if(!isset($forecast['Forecast']))
		{
			$forecast['Forecast'] = $forecast;
			$flag = 1;	
		}
		
		#does Points for day (as Y-m-d e.g. 2010-09-09)
		$actual = $this->find('all', array('conditions' => array('day' => $forecast['Forecast']['day'], 'group_id' => 10))); #Actual data
		if(count($actual) > 0)
		{
				$forecast['Forecast']['min_temp_points'] = Forecast::min_temp_points($actual[0]['Forecast']['min_temp'],$forecast['Forecast']['min_temp']);
				$forecast['Forecast']['max_temp_points'] = Forecast::max_temp_points($actual[0]['Forecast']['max_temp'],$forecast['Forecast']['max_temp']);
				$forecast['Forecast']['wind_speed_points'] = Forecast::wind_speed_points($actual[0]['Forecast']['wind_speed'],$forecast['Forecast']['wind_speed']);
				$forecast['Forecast']['wind_direction_points'] = Forecast::wind_direction_points($actual[0]['Forecast']['wind_direction'],$forecast['Forecast']['wind_direction'], $actual[0]['Forecast']['wind_speed']);
				$forecast['Forecast']['total_rainfall_points'] = Forecast::total_rainfall_points($actual[0]['Forecast']['total_rainfall'],$forecast['Forecast']['total_rainfall']);
				$forecast['Forecast']['total_points'] = $forecast['Forecast']['min_temp_points'] + $forecast['Forecast']['max_temp_points'] + $forecast['Forecast']['wind_speed_points'] + $forecast['Forecast']['wind_direction_points'] + $forecast['Forecast']['total_rainfall_points']; 
		}
		if($flag == 1)
		{
			return $forecast['Forecast'];
		}
		else
		{
			return $forecast;
		}
	}

	private function min_temp_points($actual, $predicted)
	{
		#alias
		return $this->temp_points($actual, $predicted);
	}

	private function max_temp_points($actual, $predicted)
	{
		#alias
		return $this->temp_points($actual, $predicted);
	}

	private function temp_points($actual, $predicted)
	{
		$diff = abs($predicted - $actual);
		$points = -3;
		if( $diff <= 6.5) {
			$points = -2;
			}
		if( $diff <= 5.5) {
			$points = -1;
			}
		if( $diff <= 4.5) {
			$points = 0;
			}
		if( $diff <= 3.5) {
			$points = 1;
			}
		if( $diff <= 2.5) {
			$points = 2;
			}
		if( $diff <= 1.5) {
			$points = 3;
			}
		if( $diff <= 0.5) {
			$points = 4;
			}		
		
		return $points;
	}
	private function wind_speed_points($actual, $predicted)
	{
		$diff = abs($predicted - $actual);
		$points = -2;
		if( $diff <= 11) {
			$points = -1;
			}
		if( $diff <= 9) {
			$points = 0;
			}
		if( $diff <= 7) {
			$points = 1;
			}
		if( $diff <= 5) {
			$points = 2;
			}
		if( $diff <= 3) {
			$points = 3;
		}
		if( $diff <= 1) {
			$points = 4;
		}
	
		return $points;
	}

	private function wind_direction_points($actual, $predicted, $actual_speed)
	{
        if($actual_speed == 0)
        {
            #direction is undefined, no points for anyone!
            $points = 0;
        }
        else
        {
		    $abs_diff =abs(($actual + 180 -  $predicted) % 360 - 180);
		    $diff = min($abs_diff, 360 - $abs_diff);
		    $points = -2;
		    if( $diff <= 90) {
			    $points = -1;
			    }
		    if( $diff <= 65) {
			    $points = 0;
			    }
		    if( $diff <= 45) {
			    $points = 1;
			    }
		    if( $diff <= 35) {
			    $points = 2;
			    }
		    if( $diff <= 27.5) {
		    	$points = 3;
		    }
		    if( $diff <= 22.5) {
			    $points = 4;
		    }
        }
		return $points;
	}
	private function total_rainfall_points($actual, $predicted)
	{
		$diff = abs($predicted - $actual);
		$points = -3;
		if( $diff <= 7.5) {
			$points = -2;
			}
		if( $diff <= 6.5) {
			$points = -1;
			}
		if( $diff <= 5.5) {
			$points = 0;
			}
		if( $diff <= 4.5) {
			$points = 1;
			}
		if( $diff <= 3.5) {
			$points = 2;
			}
		if( $diff <= 2.5) {
			$points = 3;
			}
		if( $diff <= 1.5) {
			$points = 4;
			}
		if( $diff <= 0.5) {
			$points = 5;
			}		
		return $points;
	}
		
	static function next_forecast($what)
	{
		$next_forecast = array();
		if(gmdate('H') > 18)
		{
			#it's evening so 1800 the following day
			$next_forecast['start'] = strtotime('tomorrow 19:00');
			$next_forecast['end'] = strtotime('+2 days 19:00');
		}
		else
		{
			#during the day
			$next_forecast['start'] = strtotime('19:00');
			$next_forecast['end'] = strtotime('tomorrow 19:00');
		}
		$next_forecast['human_readable'] = date('H:i l jS F',$next_forecast['start']).' to '.date('H:i l jS F',$next_forecast['end']).' (BST)';
		return $next_forecast[$what];
	}
	static function points_words($points)
	{
		switch ($points)
		{
			case 5:
				return 'five';
				break;
			case 4:
				return 'four';
				break;
			case 3:
				return 'three';
				break;
			case 2:
				return 'two';
				break;
			case 1:
				return 'one';
				break;
			case 0:
				return 'zero';
				break;
			case -1:
				return 'minusone';
				break;
			case -2:
				return 'minustwo';
				break;
			case -3:
				return 'minusthree';
				break;
			}
	}
	function noDuplicates($value, $params){

        /* If we happen to editing an existing record then don't count this record in the check for duplicates */

        if (!empty($this->id))

            $conditions[] = array($this->primaryKey . ' <>' => $this->id);

        /* Add a condition for each field we want to check against */

        foreach ($params as $field) {

            /* Check if value is empty. If it is then we want to check for a NULL value against this field */

            if($this->data[$this->name][$field])

                $fieldVal = $this->data[$this->name][$field];

            else

                $fieldVal = null;

            $conditions[] = array($field => $fieldVal);

        }

        $existingFieldsCount = $this->find( 'count', array('conditions' => $conditions, 'recursive' => -1) );

        return $existingFieldsCount < 1;

    }

}
?>
