<?php
namespace Sunset\Components\MoreJson;
use Sunset\Components\MoreJson\Exception\MoreJsonException;

/**
 * MoreJson is a simple library, which can help you including json to json and use parameters. It's great idea for configuration your system.
 */
class MoreJson {

	/**
	 * Array with available plugins
	 *
	 * @var array
	 */
	private $availablePlugins;

	/**
	 * Array with plugins
	 *
	 * @var array
	 */
	private $plugins;

	/**
	 * Array with params
	 *
	 * @var array
	 */
	private $params;

	/**
	 * @param array $parameters
	 */
	public function __construct($parameters = array()) {
		$this->params = array(
			'path' => null,
			'content' => null,
			'parameters' => $parameters
		);

		$this->availablePlugins = array(
			'parameters', 'import'
		);
	}

	/**
	 * Start file's parsing process
	 *
	 * @param string $fileName
	 */
	public function parse($fileName) {
		$this->params['path'] = $fileName;
		$this->params['content'] = $this->getFileContent();
		$this->usePlugins();

		return $this->params['content'];
	}

	/**
	 * Get file content
	 *
	 * @return string
	 * @throws MoreJsonException
	 */
	private function getFileContent() {
		if (file_exists($this->params['path'])) {
			return json_decode(file_get_contents($this->params['path']), true);
		}
		throw new MoreJsonException('Can\'t find file '.$this->params['path']);
	}

	/**
	 * Lets iterate and include all needed plugins
	 */
	private function usePlugins() {
		foreach ((array)$this->params['content'] as $key => $value) {
			if (in_array(strtolower($key), $this->availablePlugins)) {
				$this->plugins[$key] = $this->getPlugin($key);
				$pluginReturn = $this->plugins[$key]->run($this->params);
				$this->params['content'] = $pluginReturn['content'];
				$this->params['parameters'] = $pluginReturn['parameters'];
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
	private function getPlugin($key) {
		$pluginNamespace = implode('\\', array('Sunset\Components\MoreJson\Plugins\Plugins', ucfirst($key)));
		return new $pluginNamespace();
	}
}
