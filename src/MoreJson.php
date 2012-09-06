<?php
namespace Sunset\Components\MoreJson;

/**
 * MoreJson parser
 * Available patterns:
 * --- variables declaration ---
 * 'parameters': {
 *         'foo': 'bar'
 * }
 * $parameter - include parameter
 * --- import external json ---
 * "import": {
 *         "file1.json",
 *         "file2.json"
 * }

 */
class MoreJson {

	/**
	 * Array with available plugins
	 *
	 * @var array
	 */
	private $_availablePlugins;

	/**
	 * Array with plugins
	 *
	 * @var array
	 */
	private $_plugins;

	/**
	 * Array with params
	 *
	 * @var array
	 */
	private $_params;

	/**

	 */
	public function __construct($parameters = array()) {
		$this->_params = array(
			'path' => null,
			'content' => null,
			'parameters' => $parameters
		);

		$this->_availablePlugins = array(
			'parameters', 'import'
		);
	}

	/**
	 * Start file's parsing process
	 *
	 * @param string $fileName
	 */
	public function parse($fileName) {
		$this->_params['path'] = $fileName;
		$this->_params['content'] = $this->_getFileContent();
		$this->_usePlugins();

		return $this->_params['content'];
	}

	/**
	 * Get file content
	 *
	 * @return string
	 * @throws MoreJsonException
	 */
	private function _getFileContent() {
		if (file_exists($this->_params['path'])) {
			return json_decode(file_get_contents($this->_params['path']), true);
		}
		throw new MoreJsonException('Can\'t find file '.$this->_params['path']);
	}

	/**
	 * Lets iterate and include all needed plugins
	 */
	private function _usePlugins() {
		foreach ((array)$this->_params['content'] as $key => $value) {
			if (in_array(strtolower($key), $this->_availablePlugins)) {
				$this->_plugins[$key] = $this->_getPlugin($key);
				$pluginReturn = $this->_plugins[$key]->run($this->_params);
				$this->_params['content'] = $pluginReturn['content'];
				$this->_params['parameters'] = $pluginReturn['parameters'];
			}
		}
	}

	/**
	 * Get plugin
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	private function _getPlugin($key) {
		$pluginNamespace = implode('\\', array('Sunset\Components\MoreJson\Plugins\Plugins', ucfirst($key)));
		return new $pluginNamespace();
	}
}
