@if (Auth::check())
<div id="oauth__user">
	<span>{{ Auth::user()->name }}</span>
	<a href="/oauth/logout" id="oauth__logout">{{ trans('Logout') }}</a>
</div>
@else
<a href="/oauth/google/redirect" title="{{ trans('Sign in with Google') }}">
	<div class="google-button">
		<img src="vendor/socialites/icons8-google.png" alt="Login with Google">
		<span> {{ trans('Sign in with Google') }} </span>
	</div>
</a>
<a href="/oauth/github/redirect" title="{{ trans('Sign in with Github') }}">
	<div class="github-button">
		<img src="vendor/socialites/icons8-github.png" alt="Login with Github">
		<span> {{ trans('Sign in with Github') }} </span>
	</div>
</a>
@endif

<style>
	.google-button {
		position: fixed;
		bottom: 20px;
		left: 20px;
		padding: 15px 25px;
		color: #0a0a0a;
		background: #fff;
		border-radius: var(--btn-border-radius, 50px);
		border: 1px solid #e7e7e7;
		box-shadow: 0px 0px 5px #0001
	}

	.google-button img {
		float: left;
		margin-right: 20px;
		width: 25px;
	}

	.google-button span {
		float: left;
		font-size: 15px;
		font-weight: 600;
		font-family: Poppins
	}

	.github-button {
		position: fixed;
		bottom: 90px;
		left: 20px;
		padding: 15px 25px;
		color: #0a0a0a;
		background: #fff;
		border-radius: var(--btn-border-radius, 50px);
		border: 1px solid #e7e7e7;
		box-shadow: 0px 0px 5px #0001
	}

	.github-button img {
		float: left;
		margin-right: 20px;
		width: 25px;
	}

	.github-button span {
		float: left;
		font-size: 15px;
		font-weight: 600;
		font-family: Poppins, Arial, sans-serif;
	}
</style>