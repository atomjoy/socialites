<?php


namespace Atomjoy\Socialites\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Atomjoy\Socialites\Events\UserCreated;
use Atomjoy\Socialites\Events\UserLogged;
use Illuminate\Support\Facades\Validator;

class OauthLogin extends Controller
{
	/**
	 * Check driver
	 */
	function checkDriver()
	{
		if (!in_array(
			request('driver'),
			(array) config('services.oauth_drivers', ['github', 'google'])
		)) {
			throw new \Exception("Invalid oauth driver.");
		}
	}

	/**
	 * Logout
	 *
	 * @return void
	 */
	public function logout($driver = 'google')
	{
		Auth::logout();

		$this->checkDriver();

		return redirect(config('services.' . $driver . '.homepage', '/'));
	}

	/**
	 * Redirect to oauth
	 *
	 * @return void
	 */
	public function redirect($driver = 'google')
	{
		$this->checkDriver();

		return Socialite::driver($driver)->redirect();
	}

	/**
	 * Callback from oauth
	 *
	 * @return void
	 */
	public function callback($driver = 'google')
	{
		$this->checkDriver();

		$oauthUser = Socialite::driver($driver)->stateless()->user();

		$validator = Validator::make(['email' => $oauthUser->email], [
			'email' => 'required|email:rfc,dns'
		]);

		if ($validator->fails()) {
			throw new \Exception("Invalid email address.", 422);
		}

		$user = User::where('email', $oauthUser->email)->first();
		if (!$user) {
			$user = User::create([
				'name' => $oauthUser->name,
				'email' => $oauthUser->email,
				'password' => Hash::make(md5(uniqid() . microtime())),
				'email_verified_at' => now(), // Add in User fillable
			]);

			UserCreated::dispatch($user);
		}
		Auth::login($user);
		UserLogged::dispatch($user);
		return redirect(config('services.' . $driver . '.homepage', '/'));
	}

	public function oauth($driver = 'google')
	{
		if ($driver != 'google') {
			return redirect(config('services.google.homepage', '/'));
		}

		$token = request()->input('token');
		$client = config('services.google.client_id');
		$res = Http::get("https://oauth2.googleapis.com/tokeninfo", ["id_token" => $token]);

		if ($res->ok()) {
			$arr = $res->json();
			if ($arr['aud'] != $client) {
				return redirect(config('services.google.homepage', '/'));
			}

			$validator = Validator::make(['email' => $arr['email']], [
				'email' => 'required|email:rfc,dns'
			]);

			if ($validator->fails()) {
				throw new \Exception("Invalid email address.", 422);
			}

			$user = User::where('email', $arr['email'])->first();
			if (!$user) {
				$user = User::create([
					'name' => $arr['name'],
					'email' => $arr['email'],
					'password' => Hash::make(md5(uniqid() . microtime())),
					'email_verified_at' => now(), // Add in User fillable
				]);

				UserCreated::dispatch($user);
			}
			Auth::login($user);
			UserLogged::dispatch($user);
		}
		return redirect(config('services.google.homepage', '/'));
	}
}
