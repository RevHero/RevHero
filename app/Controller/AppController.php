<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $helpers = array('Html', 'Form');
	
	public function beforeFilter() {
		parent::beforeFilter();
	}
}
