<?php

return [
	'google' => [
		'client_id' => env('GOOGLE_CLIENT_ID'),
		'client_secret' => env('GOOGLE_CLIENT_SECRET'),
		'redirect' => env('GOOGLE_REDIRECT_URL'),
		'homepage' => env('GOOGLE_HOME_URL'),
	],

	'github' => [
		'client_id' => env('GITHUB_CLIENT_ID'),
		'client_secret' => env('GITHUB_CLIENT_SECRET'),
		'redirect' => env('GITHUB_REDIRECT_URL'),
		'homepage' => env('GITHUB_HOME_URL'),
	],

	'oauth_drivers' => ['github', 'google']
];
