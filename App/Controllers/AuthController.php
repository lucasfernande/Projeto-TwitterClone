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

			if ($usuario->__get('id') != '' AND $usuario->__get('nome') != '') {
				echo 'Autenticado';
			}
			else {
				header('Location: /?login=error');
			}
		}

	}

?>