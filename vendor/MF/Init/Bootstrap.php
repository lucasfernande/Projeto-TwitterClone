<?php  

	namespace MF\Init;

	abstract class Bootstrap {
		private $routes;

		abstract protected function initRoutes();

		public function __construct() {
			$this->initRoutes();
			$this->run($this->getUrl());
		}

		public function getRoutes() {
			return $this->routes;
		}
		
		public function setRoutes(array $routes) {
			$this->routes = $routes;
		}

		protected function run($url) {
			foreach ($this->getRoutes() as $path => $route) {
				if ($url == $route['route']) {
					$class = 'App\\Controllers\\'.ucfirst($route['controller']); # formando o nome da classe de acordo com a url

					$controller = new $class; # App\Controllers\IndexController
					$action = $route['action']; # recuperando a action que corresponde a url
					$controller->$action();
				}
			}
		}

		protected function getUrl() { # buscando onde a url atual do usuario
			return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); # retorna os componentes da url
		}
	}

?>