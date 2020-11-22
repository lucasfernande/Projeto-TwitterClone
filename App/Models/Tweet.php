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
	}	

?>	