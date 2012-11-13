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
	 * @param array $plugins
	 */
	public function __construct($parameters = array(), $plugins = array()) {
		$this->params = array(
			'path' => null,
			'content' => null,
			'parameters' => $parameters
		);
		$this->plugins = $plugins;

		$this->availablePlugins = array(
			'Parameters', 'Import', 'MagicConstants', 'Methods'
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
		$this->registerPlugins();
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

	private function registerPlugins() {
		if (empty($this->plugins)) {
			foreach ($this->availablePlugins as $plugin) {
				$this->plugins[] = $this->getPlugin($plugin);
			}
		}
	}

	/**
	 * Lets iterate and include all needed plugins
	 */
	private function usePlugins() {
		foreach($this->plugins as $plugin) {
			$pluginReturn = $plugin->run($this->params);
			$this->params['content'] = $pluginReturn['content'];
			$this->params['parameters'] = $pluginReturn['parameters'];
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
