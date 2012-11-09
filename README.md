MoreJson
========


What is MoreJson?
-----------------

MoreJson is a simple library, which can help you including json to json and use parameters. It's great idea for configuration your system.

How to use?
-----------

Using a MoreJson is very simply. Even child can do this!


```php
<?php

$moreJson = new MoreJson();
$json = $moreJson->parse("foo.json");
...
```

How to compose .json file?
--------------------------

Currently, MoreJson contains 2 plugins: Import and Parameters.
* Import - usefull plugin for import one json file to another
* Parameters - plugin for declaring the properties (variables)

file1.json:
```
{
	"parameters":{
		"$test":"test"
	},
	"foo": "$foo",
	"testing": "$test"
}
```
file2.json:
```
{
	"parameters": {
		"$username": "abdulklara",
		"$foo": "bar"
	},
	"import": {
		"file2.json":""
	},
	"login": "$username"
}
```

In output you will have:
```php
array(4) {
  ["parameters"]=>
  array(3) {
    ["$test"]=>
    string(4) "test"
    ["$username"]=>
    string(10) "abdulklara"
    ["$foo"]=>
    string(3) "bar"
  }
  ["login"]=>
  string(10) "abdulklara"
  ["foo"]=>
  string(3) "bar"
  ["testing"]=>
  string(4) "test"
}
```

That's it!

License
-------
MoreJson is licensed under the MIT License
