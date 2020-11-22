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
	}	

?>	