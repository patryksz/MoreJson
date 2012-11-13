<?php
namespace Sunset\Components\MoreJson\Plugins\Lib;
/**
 * @package Lib
 */
class Methods {

	private $methods = array(
		"time" => null
	);

	public function __construct() {
		$this->registerMethods();
	}

	private function registerMethods() {
		foreach ($this->methods as $key => &$value) {
			$value = $this->getClass($key);
		}
	}

	/**
	 * Get method class
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	private function getClass($key) {
		$methodNamespace = implode('\\', array('Sunset\Components\MoreJson\Plugins\Lib\Methods', ucfirst($key)));
		return new $methodNamespace();
	}

	public function get($method) {
		if (!empty($method) && !empty($this->methods[$method])) {
			return $this->methods[$method];
		}
		return null;
	}
}
