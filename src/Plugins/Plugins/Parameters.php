<?php
namespace Sunset\Components\MoreJson\Plugins\Plugins;
use Sunset\Components\MoreJson\Plugins\PluginInterface;

class Parameters implements PluginInterface {

	/**
	 * array with parameters from json
	 *
	 * @var array
	 */
	private $_parameters;

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

		$this->_parameters = array_merge((array) $input['parameters'], $parameters);
		array_walk_recursive($input, array($this, '_replaceParameters'));
		$input['parameters'] = $this->_parameters;

		return array(
			"content" => $input,
			"parameters" => $this->_parameters
		);
	}

	/**
	 * If find $parameter, replace to value of this parameter
	 *
	 * @param string $item
	 * @param string $key
	 */
	private function _replaceParameters(&$item, $key){
		if (!empty($this->_parameters[$item])) {
			$item = $this->_parameters[$item];
		}
	}
}
