<?php
namespace Sunset\Components\Json\Plugins\Plugins;
use Sunset\Components\Json\Plugins\PluginInterface;
use Sunset\Components\Json\Json;

class Import implements PluginInterface {

	/**
	 * Import external json to current object
	 *
	 * @param mixed $input
	 *
	 * @return mixed
	 */
	public function run($input) {
		foreach ((array)$input->import as $import => $value) {
			$json = new Json();
			$input = array_merge((array)$input, (array)$json->parse($import));
		}

		return $input;
	}
}
