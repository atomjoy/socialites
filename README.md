# Google and Github Login with Laravel Socialite

How to add Google and Github login using Socialite in Laravel. Google One Tap with Vue and Laravel Socialite.

## Install

Add package and routes.

```sh
composer require "atomjoy/socialites"
```

## Callbacks

Change the callback domain.

```sh
# Google
https://example.org/oauth/google/callback

# Github
https://example.org/oauth/github/callback
```

## Create Google project

<https://console.cloud.google.com/projectcreate>

## Create Google OAuth consent screen

Create a consent screen for an app with permissions to:

- auth/userinfo.email
- auth/userinfo.profile
- openid

## Create Google oauth keys

Create **External** OAuth 2.0 client IDs add callback and retrieve keys

<https://console.cloud.google.com/apis/credentials>

## Create a new oauth app on Github and get the keys

<https://github.com/settings/developers>

## Setings

Update the .env file in the callback links, just change the domain.

```sh
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URL=https://example.org/oauth/google/callback
GOOGLE_HOME_URL=/

GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
GITHUB_REDIRECT_URL=https://example.org/oauth/github/callback
GITHUB_HOME_URL=/
```

## Config service

Append in config/services.php

```php
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
```

## Login buttons

```html
@if (Auth::check())
    <div>{{ Auth::user()->name }}</div>
    <a href="/oauth/google/logout" title="Logout">{{ trans('Logout') }}</a>
@else
    <a href="/oauth/google/redirect" title="Google">{{ trans('Login with Google') }}</a>
    <a href="/oauth/github/redirect" title="Github">{{ trans('Login with Github') }}</a>
@endif
```

## Javascript Google One Tap dialog and button (optional)

```html
@if (!Auth::check())
<div id="buttonDiv"></div>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    function handleCredentialResponse(response) {
        window.location.href = '/oauth/google/redirect'
        // Here we can do whatever process with the response we want (optional)
        // Note that response.credential is a JWT ID token
        // console.log("Encoded JWT ID token: " + response.credential);
        // fetch('/oauth/google/oauth?token=' + response.credential)
    }

    window.onload = function () {
        google.accounts.id.initialize({
            client_id: "{{ config('services.google.client_id') }}", // Or replace with your Google Client ID
            callback: handleCredentialResponse // We choose to handle the callback in client side, so we include a reference to a function that will handle the response
        });
        // Show "Sign-in" button (optional)
        // google.accounts.id.renderButton(document.getElementById("buttonDiv"),{ theme: "outline", size: "small" });
        // Display the One Tap dialog
        google.accounts.id.prompt();
        // Hide One Tap onclick
        const button = document.querySelector('body');
        button.onclick = () => {
            google.accounts.id.disableAutoSelect();
            google.accounts.id.cancel();
        }
    }
</script>
@endif
```

## Server

```sh
php artisan serve --host=localhost --port=8000
```

## Add more drivers in the configuration file

Append in config/services.php

```php
<?php

return [
    //...

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URL'),
        'homepage' => env('FACEBOOK_HOME_URL'),
    ],

    'oauth_drivers' => ['github', 'google', 'facebook'],
];
```

## Events

```php
<?php

use Atomjoy\Socialites\Events\UserLogged;
use Atomjoy\Socialites\Events\UserCreated;
```

## Config example (not used)

config/socialites.php

```sh
php artisan vendor:publish --tag=socialites-config --force
```
