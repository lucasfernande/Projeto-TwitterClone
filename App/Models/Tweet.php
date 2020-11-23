<?php  

	namespace App\Models;
	use MF\Model\Model;

	class Tweet extends Model {
		private $id;
		private $id_usuario;
		private $tweet;
		private $data;

		public function __get($attr) {
			return $this->$attr;
		}

		public function __set($attr, $value) {
			$this->$attr = $value;
		}

		public function salvar() {
			$query = 'insert into tweets(id_usuario, tweet)values(:id_usuario, :tweet)';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$statemt->bindValue(':tweet', $this->__get('tweet'));
			$statemt->execute();

			return $this;
		}

		public function recuperarTweets() {
			$query = 'select 
						t.id, t.id_usuario, u.nome, t.tweet, DATE_FORMAT(t.data, "%d/%m/%Y %H:%i") as data 
					  from 
					  	tweets as t 
					 	left join usuarios as u on(t.id_usuario = u.id)
					  where 
					  	t.id_usuario = :id_usuario
					  	or t.id_usuario in(select id_usuario_seguindo from usuarios_seguidores where id_usuario = :id_usuario)
					  order by 
					  	t.data DESC';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$statemt->execute();

			return $statemt->fetchAll(\PDO::FETCH_OBJ); # retornando um objeto literal com todos os tweets
		}

		public function remover() {
			$query = 'delete from tweets where id = :id';

			$statemt = $this->db->prepare($query);
			$statemt->bindValue(':id', $this->__get('id'));

			$statemt->execute();
			return true;
		}
	}	

?>	