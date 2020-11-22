<?php  

	namespace App\Controllers;

	use MF\Model\Container;
	use MF\Controller\Action;

	class AuthController extends Action {

		public function autenticar() {
			$usuario = Container::getModel('Usuario'); # instanciando um objeto usuario

			$usuario->__set('email', $_POST['email']);
			$usuario->__set('senha', $_POST['senha']);

			$usuario->autenticar();

			if ($usuario->__get('id') != '' AND $usuario->__get('nome') != '') { # caso as variáveis de sessão não estejam preenchidas, será forçado o redirecionamento para a tela de login

				session_start(); # iniciando sessão
				$_SESSION['id'] = $usuario->__get('id');
				$_SESSION['nome'] = $usuario->__get('nome');
				header('Location: /timeline');
			}
			else {
				header('Location: /?login=error');
			}
		}

		public function sair() {
			session_start();
			session_destroy();
			header('Location: /');
		}

	}

?>