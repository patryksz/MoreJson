<?php
namespace Sunset\Components\MoreJson\Plugins\Plugins;
use Sunset\Components\MoreJson\Plugins\PluginInterface;
use Sunset\Components\MoreJson\MoreJson;

/**
 * @package Plugins
 */
class Import implements PluginInterface {

	/**
	 * Import external json to current object
	 *
	 * @param array params
	 *
	 * @return mixed
	 */
	public function run($params) {
		$input = $params['content'];
		$parameters = $params['parameters'];
		$path = $this->_getPath($params);

		foreach ((array)$input['import'] as $import => $value) {
			$importPath = implode("/", array($path, $import));
			$json = new MoreJson($parameters);
			$input = array_merge((array)$input, (array)$json->parse($importPath));
		}
		unset($input['import']);
		return array(
			"content" => $input,
			"parameters" => $parameters
		);
	}

	/**
	 * Get directory from path to file
	 *
	 * @param array $params
	 *
	 * @return string
	 */
	private function _getPath($params){
		return substr($params['path'], 0, strrpos($params['path'], "/"));
	}
}
