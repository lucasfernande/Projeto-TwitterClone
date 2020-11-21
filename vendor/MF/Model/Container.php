<?php  

	namespace MF\Model;
	use App\Connection;

	class Container {

		public static function getModel($model) {
			$class = "\\App\\Models\\".ucfirst($model); # criando o nome da class dinamicamente com base no parâmetro $model 

			$conn = Connection::getDb();
			return new $class($conn); # retorna a classe passada como parâmetro já instanciada e com a conexão com o banco de dados
		}
	}

?>