<?php
namespace Sunset\Components\Json\Plugins\Plugins;
use Sunset\Components\Json\Plugins\PluginInterface;
use Sunset\Components\Json\Json;

class Import implements PluginInterface {

	private $_params;

	/**
	 * Import external json to current object
	 *
	 * @param array $input
	 * @param array $parameters
	 *
	 * @return mixed
	 */
	public function run($input, $parameters) {
		foreach ((array)$input['import'] as $import => $value) {
			$json = new Json($parameters);
			$input = array_merge((array)$input, (array)$json->parse($import, $parameters));
		}
		unset($input['import']);
		return array(
			"content" => $input,
			"parameters" => $parameters
		);
	}
}
