<?php

	namespace App\Controllers;

	use MF\Model\Container;
	use MF\Controller\Action;

	class IndexController extends Action {

		public function index() {
			$this->view->login = isset($_GET['login']) ? $_GET['login']: '';
			$this->render('index');
		}

		public function inscreverse() {
			$this->view->usuario = array ( # array para colocar as informações no formulário novamente ao acontecer um erro
					'nome' => '',
					'email' => '',
					'senha' => ''
			);
			$this->view->erroCadastro = false;
			$this->render('inscreverse');
		}

		public function registrar() {
			$usuario = Container::getModel('Usuario');

			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('email', $_POST['email']);
			$usuario->__set('senha', $_POST['senha']);

			if ($usuario->validarCadastro() AND count($usuario->getUsuarioPorEmail()) == 0) {
				$usuario->cadastrar();	
				$this->render('cadastro'); # renderizando tela de cadastro com sucesso								
			} 
			else {
				$this->view->usuario = array ( 
					'nome' => $_POST['nome'],
					'email' => $_POST['email'],
					'senha' => $_POST['senha']
				);
				$this->view->erroCadastro = true;
				$this->render('inscreverse');
			}
		}

	}


?>