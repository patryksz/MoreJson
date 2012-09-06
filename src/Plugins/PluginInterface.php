<?php
namespace Sunset\Components\MoreJson\Plugins;

interface PluginInterface {

	/**
	 * Run plugin process returning input
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function run($params);
}
