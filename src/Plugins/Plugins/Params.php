<?php
namespace Sunset\Components\Json\Plugins\Plugins;
use Sunset\Components\Json\Plugins\PluginInterface;

class Params implements PluginInterface {

	/**
	 * Initialize parameters and include parameters in json
	 *
	 * @param mixed $input
	 *
	 * @return mixed
	 */
	public function run($input) {
		return $input;
	}
}
