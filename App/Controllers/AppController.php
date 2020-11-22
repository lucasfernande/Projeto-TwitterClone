<?php  

	namespace App\Controllers;

	use MF\Model\Container;
	use MF\Controller\Action;

	class AppController extends Action {

		public function timeline() {
			session_start();

			if ($_SESSION['id'] != '' AND $_SESSION['nome'] != '') {
				$this->render('timeline');
			}
			else {
				header('Location: /?login=error');
			}		
		}

		public function tweet() {
			session_start();

			if ($_SESSION['id'] != '' AND $_SESSION['nome'] != '') {
				$tweet = Container::getModel('Tweet');

				$tweet->__set('tweet', $_POST['tweet']);
				$tweet->__set('id_usuario', $_SESSION['id']); # setando o id do usuario que fez o post

				$tweet->salvar();

			}
			else {
				header('Location: /?login=error');
			}
			
		}
	}	

?>	