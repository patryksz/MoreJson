<?php
namespace Sunset\Components\MoreJson\Plugins\Plugins;
use Sunset\Components\MoreJson\Plugins\PluginInterface;
use Sunset\Components\MoreJson\Plugins\Lib\Methods as Method;

/**
 * @package Plugins
 */
class Methods implements PluginInterface {

	/**
	 * @var Method
	 */
	private $method;

	/**
	 * Search in array for special vars and replace them
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function run($params) {
		$this->method = new Method();

		$input = $params['content'];

		array_walk_recursive($input, array($this, 'useMethods'));
		return array(
			"content" => $input,
			"parameters" => $input['parameters']
		);
	}

	/**
	 * @param string $item
	 * @param string $key
	 */
	private function useMethods(&$item, $key) {
		preg_match_all("/>([a-zA-Z0-9]+):([a-zA-Z0-9,]+)$/", $item, $matched);
		if (!empty($matched[0])) {
			$methodSlice = array_slice($matched, 1);
			$method = $this->method->get($methodSlice[0][0]);
			$item = call_user_func_array(array($method, 'run'), explode(",", $methodSlice[1][0]));
		}
	}
}
