<?php
namespace Sunset\Components\MoreJson\Plugins;

interface PluginInterface {

	/**
	 * Run plugin process
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function run($params);
}
