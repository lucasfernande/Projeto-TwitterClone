<?php

	namespace App\Controllers;

	use MF\Model\Container;
	use MF\Controller\Action;

	class IndexController extends Action {

		public function index() {
			$this->render('index');
		}

		public function inscreverse() {
			$this->render('inscreverse');
		}

	}


?>