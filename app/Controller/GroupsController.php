<?php
class GroupsController extends AppController {

	var $name = 'Groups';
	var $helpers = array('Html', 'Form');

	function index() {
		$groups = $this->Group->find('all', array('conditions' => array('Group.id <>' => '10')));
		foreach($groups as $group_key => $group)
		{
			foreach($group['Forecast'] as $forecast_key => $forecast)
			{
				$groups[$group_key]['Forecast'][$forecast_key] = $this->Group->Forecast->points($forecast);
			}	
		}
		$this->set(compact('groups'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Group'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('group', $this->Group->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The Group has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Group could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Group'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The Group has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Group could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Group->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Group'));
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->Group->del($id)) {
			$this->Session->setFlash(__('Group deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Group could not be deleted. Please, try again.'));
		return $this->redirect(array('action' => 'index'));
	}

}
?>
