<?php
namespace Sunset\Components\Json;

/**
 * Json parser
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
class Json {

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
	public function __construct() {
		$this->_params = array(
			'fileName' => null,
			'fileContentDecoded' => null,
			'parameters' => array()
		);

		$this->_availablePlugins = array(
			'params', 'import'
		);
	}

	/**
	 * Start file's parsing process
	 *
	 * @param string $fileName
	 */
	public function parse($fileName) {
		$this->_params['fileName'] = $fileName;
		$this->_params['fileContentDecoded'] = $this->_getFileContent();
		$this->_includePlugins();
		$this->_executePlugins();

		return $this->_params['fileContentDecoded'];
	}

	/**
	 * Get file content
	 *
	 * @return string
	 * @throws JsonException
	 */
	private function _getFileContent() {
		if (file_exists($this->_params['fileName'])) {
			return json_decode(file_get_contents($this->_params['fileName']));
		}
		throw new JsonException('Can\'t find file '.$this->_params['fileName']);
	}

	/**
	 * Lets iterate and include all needed plugins
	 */
	private function _includePlugins() {
		foreach ((array)$this->_params['fileContentDecoded'] as $key => $value) {
			if (in_array(strtolower($key), $this->_availablePlugins)) {
				$this->_plugins[] = $this->_getPlugin($key);
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
		$pluginNamespace = implode('\\', array('Sunset\Components\Json\Plugins\Plugins', ucfirst($key)));
		return new $pluginNamespace();
	}

	/**
 	 * execute plugins
	 */
	private function _executePlugins() {
		foreach ((array)$this->_plugins as $plugin) {
			$this->_params['fileContentDecoded'] = $plugin->run($this->_params['fileContentDecoded']);
		}
	}
}
