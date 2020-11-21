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

		public function registrar() {
			$usuario = Container::getModel('Usuario');

			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('email', $_POST['email']);
			$usuario->__set('senha', $_POST['senha']);
			$usuario->cadastrar();		

		}

	}


?>