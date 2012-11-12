<?php
namespace Sunset\Components\MoreJson\Plugins\Plugins;
use Sunset\Components\MoreJson\Plugins\PluginInterface;
/**
 * @package Plugins
 */
class Parameters implements PluginInterface {

	/**
	 * array with parameters from json
	 *
	 * @var array
	 */
	private $parameters;

	/**
	 * Initialize parameters and include parameters in json
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function run($params) {
		$input = $params['content'];
		$parameters = $params['parameters'];

		$this->parameters = array_merge((array) $input['parameters'], $parameters);
		array_walk_recursive($input, array($this, 'replaceParameters'));
		$input['parameters'] = $this->parameters;

		return array(
			"content" => $input,
			"parameters" => $this->parameters
		);
	}

	/**
	 * If find $parameter, replace to value of this parameter
	 *
	 * @param string $item
	 * @param string $key
	 */
	private function replaceParameters(&$item, $key){
		if (!empty($this->parameters[substr($item, 1)])) {
			$item = $this->parameters[substr($item, 1)];
		}
	}
}
