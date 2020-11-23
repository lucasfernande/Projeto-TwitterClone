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

			$usuario = Container::getModel('Usuario');		
			$usuario->__set('id', $_SESSION['id']);

			$this->view->infoUsuario = $usuario->getInfoUsuario();
			$this->view->totalTweets = $usuario->getTotalTweets();
			$this->view->totalSeguindo = $usuario->getTotalSeguindo();
			$this->view->totalSeguidores = $usuario->getTotalSeguidores();

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

		public function quemSeguir() {
			$this->validaAutenticacao();

			$usuarios = array(); # caso não seja encontrado nenhum usuário, será retornado um array vazio
			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

			if ($pesquisarPor != '') {
				$usuario = Container::getModel('Usuario');
				$usuario->__set('nome', $pesquisarPor);
				$usuario->__set('id', $_SESSION['id']);

				$usuarios = $usuario->pesquisar();
			}

			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			
			$this->view->infoUsuario = $usuario->getInfoUsuario();
			$this->view->totalTweets = $usuario->getTotalTweets();
			$this->view->totalSeguindo = $usuario->getTotalSeguindo();
			$this->view->totalSeguidores = $usuario->getTotalSeguidores();

			$this->view->usuarios = $usuarios;
			$this->render('quemSeguir');
		}

		public function acao() {
			$this->validaAutenticacao();

			$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
			$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : ''; # usuario que vai ser seguido

			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']); # usuario que vai seguir alguém

			if ($acao == 'seguir') {
				$usuario->seguirUsuario($id_usuario_seguindo);
			}
			else if ($acao = 'deixarSeguir') {
				$usuario->deixarSeguirUsuario($id_usuario_seguindo);
			}
			header('Location: /quemseguir');
		}

		public function remover() {
			$this->validaAutenticacao();
			
			$tweet = Container::getModel('Tweet');
			$tweet->__set('id', $_GET['id']);
			
			$tweet->remover();
			header('Location: /timeline');
		}
	}	

?>	