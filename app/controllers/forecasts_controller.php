<?php
class ForecastsController extends AppController {

	var $name = 'Forecasts';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Forecast->recursive = 0;
		$this->set('forecasts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Forecast', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('forecast', $this->Forecast->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Forecast->create();
			if ($this->Forecast->save($this->data)) {
				$this->Session->setFlash(__('The Forecast has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Forecast could not be saved. Please, try again.', true));
			}
		}
		$groups = $this->Forecast->Group->find('list');
		$this->set(compact('groups'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Forecast', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Forecast->save($this->data)) {
				$this->Session->setFlash(__('The Forecast has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Forecast could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Forecast->read(null, $id);
		}
		$groups = $this->Forecast->Group->find('list');
		$this->set(compact('groups'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Forecast', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Forecast->del($id)) {
			$this->Session->setFlash(__('Forecast deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Forecast could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>