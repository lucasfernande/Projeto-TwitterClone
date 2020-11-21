<?php  

	namespace App\Models;
	use MF\Model\Model;

	class Usuario extends Model {
		private $id;
		private $nome;
		private $email;
		private $senha;

		public function __get($attr) {
			return $this->$attr;
		}

		public function __set($attr, $value) {
			$this->$attr = $value;
		}

		public function cadastrar() {
			$query = 'insert into usuarios(nome, email, senha)values(:nome, :email, :senha)';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':nome', $this->__get('nome'));
			$statemt->bindValue(':email', $this->__get('email'));
			$statemt->bindValue(':senha', $this->__get('senha'));
			$statemt->execute();

			return $this;
		}

		public function validarCadastro() {
			$valido = true;

			if(strlen($this->__get('nome')) < 2 OR strlen($this->__get('email')) < 2 OR strlen($this->__get('senha')) < 2) {
				$valido = false;
			}
			return $valido;
		}

		public function getUsuarioPorEmail() {
			$query = 'select nome, email from usuarios where email = :email';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':email', $this->__get('email'));
			$statemt->execute();

			return $statemt->fetchAll(\PDO::FETCH_ASSOC);
		}

	}

?>