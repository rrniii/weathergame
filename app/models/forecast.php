<?php
class Forecast extends AppModel {

	var $name = 'Forecast';

	var $validate = array(
		'min_temp' => array(	'rule' => array('decimal',1),
					'message' => 'Must be numeric, to nearest 0.1°C'
					),
		'max_temp' => array(	'rule' => array('decimal',1),
					'message' => 'Must be numeric, to nearest 0.1°C'
					),
		'total_rainfall' => array (	'ruleOne' => array(
							'rule' => array('comparison', '>=', 0),
							'message' => 'Must be integer greater than or equal to 0',),
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

	function beforeSave()
	{
		$this->data['Forecast']['day'] = date('Y-m-d', strtotime('tomorrow'));
		return true;
	}

}
?>
