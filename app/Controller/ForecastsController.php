<?php
class ForecastsController extends AppController {

	var $name = 'Forecasts';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Forecast->recursive = 0;
		$this->set('forecasts', $this->paginate());
	}

	function today()
	{
		#displays today's predictions of tomorrow's weather
		$forecasts = $this->Forecast->find('all',array('conditions' => array('day' => date('Y-m-d',Forecast::next_forecast('start')))));
		$groups = $this->Forecast->Group->find('all');
		
		$this->set(compact('groups','forecasts'));
	}

	function show_points($day)
	{
		$forecasts = $this->Forecast->find('all',array('conditions'=>array('Forecast.day' => $day)));
		foreach($forecasts as $key => $forecast)
		{
			$forecasts[$key] = $this->Forecast->points($forecast);
		}
		#sort by total points
		uasort($forecasts, array($this,'cmp'));
		$this->set(compact('forecasts','day'));
	}

	private function cmp($a, $b) 
	{
    		return ($b['Forecast']['total_points'] - $a['Forecast']['total_points']);
	}



	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Forecast'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('forecast', $this->Forecast->read(null, $id));
	}

	function add() {
		
		if (!empty($this->request->data)) {
			$this->Forecast->create();
			if ($this->Forecast->save($this->request->data)) {
				$this->Session->setFlash(__('The Forecast has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Forecast could not be saved. Please, try again.'));
			}
		}
		$groups = $this->Forecast->Group->find('list');
		$this->set(compact('groups'));
	}

	function add_actual()
	{
		
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Forecast'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Forecast->save($this->request->data)) {
				$this->Session->setFlash(__('The Forecast has been saved'));
				return $this->redirect(array('action' => 'index', 'admin' => false));
			} else {
				$this->Session->setFlash(__('The Forecast could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Forecast->read(null, $id);
		}
		$groups = $this->Forecast->Group->find('list');
		$this->set(compact('groups'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Forecast'));
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->Forecast->del($id)) {
			$this->Session->setFlash(__('Forecast deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Forecast could not be deleted. Please, try again.'));
		return $this->redirect(array('action' => 'index'));
	}

}
?>
