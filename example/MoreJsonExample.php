<?php

require_once __DIR__.'/../bootstrap.php';

$moreJson = new Sunset\Components\MoreJson\MoreJson();
$json = $moreJson->parse(__DIR__."/../src/Sunset/Components/MoreJson/Tests/Resources/Fixtures/sample.json");
var_dump($json);