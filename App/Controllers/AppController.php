<?php  

	namespace App\Controllers;

	use MF\Model\Container;
	use MF\Controller\Action;

	class AppController extends Action {

		public function timeline() {

			$this->validaAutenticacao();

			$tweet = Container::getModel('Tweet');

			$tweet->__set('id_usuario', $_SESSION['id']);
			$tweet = $tweet->recuperarTweets();

			$this->view->tweets = $tweet;	
			$this->render('timeline');

		}
	
		public function tweet() {

			$this->validaAutenticacao();

			$tweet = Container::getModel('Tweet');

			$tweet->__set('tweet', $_POST['tweet']);
			$tweet->__set('id_usuario', $_SESSION['id']); # setando o id do usuario que fez o post

			$tweet->salvar();
			header('Location: /timeline');

		}	

		public function validaAutenticacao() {
			session_start();

			if (!isset($_SESSION['id']) OR $_SESSION['id'] == '' OR !isset($_SESSION['nome']) OR $_SESSION['nome'] == '') {
				header('Location: /?login=error');
			}		
		}
	}	

?>	