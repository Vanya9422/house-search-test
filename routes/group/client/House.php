<?php

Route::group([
	'prefix' => 'houses',
	'namespace' => 'Client\House',
], function () {

	Route::get('/', 'IndexController');
});
