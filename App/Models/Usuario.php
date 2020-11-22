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

		public function autenticar() {
			$query = 'select id, nome, email from usuarios where email = :email AND senha = :senha';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':email', $this->__get('email'));
			$statemt->bindValue(':senha', $this->__get('senha'));
			$statemt->execute();

			$usuario = $statemt->fetch(\PDO::FETCH_OBJ);

			if ($usuario->id != '' AND $usuario->nome != '') {
				$this->__set('id', $usuario->id);
				$this->__set('nome', $usuario->nome);
			}
			return $this;
		}

		public function pesquisar() {
			$query = 'select 
						u.id, u.nome, u.email,
						(select 
							count(*) 
						from 
							usuarios_seguidores as us 
						where 
							us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id) as seguindoSN 
				  	  from 
						usuarios as u 
				 	  where 
				  		u.nome like :nome and u.id != :id_usuario';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':nome', '%'.$this->__get('nome').'%'); # pode ter qualquer string dos lados do nome pesquisado
			$statemt->bindValue(':id_usuario', $this->__get('id')); # não será retornado o próprio usuário na pesquisa
			$statemt->execute();

			return $statemt->fetchAll(\PDO::FETCH_OBJ);
		}

		public function seguirUsuario($id_usuario_seguindo) {
			$query = 'insert into usuarios_seguidores(id_usuario, id_usuario_seguindo)values(:id_usuario, :id_usuario_seguindo)';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':id_usuario', $this->__get('id'));
			$statemt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
			$statemt->execute();

			return true;
		}

		public function deixarSeguirUsuario($id_usuario_seguindo) {
			$query = 'delete from usuarios_seguidores where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':id_usuario', $this->__get('id'));
			$statemt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
			$statemt->execute();

			return true;
		}

	}

?>