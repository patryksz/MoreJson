<?php
namespace Sunset\Components\MoreJson\Plugins\Plugins;
use Sunset\Components\MoreJson\Plugins\PluginInterface;
use Sunset\Components\MoreJson\Plugins\Lib\MagicConstants as Constants;

/**
 * @package Plugins
 */
class MagicConstants implements PluginInterface {

	/**
	 * Search in array for special vars and replace them
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function run($params) {
		$constants = new Constants($params['path']);
		$this->constants = $constants->getConstants();

		$input = $params['content'];

		array_walk_recursive($input, array($this, 'replaceConstants'));

		return array(
			"content" => $input,
			"parameters" => $input['parameters']
		);
	}

	/**
	 * @param string $item
	 * @param string $key
	 */
	private function replaceConstants(&$item, $key) {
		if (!empty($this->constants[$item])) {
			$item = $this->constants[$item];
		}
	}
}
