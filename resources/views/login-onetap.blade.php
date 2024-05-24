@if (!Auth::check())
<div id="buttonDiv"></div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
	function handleCredentialResponse(response) {
		window.location.href = '/oauth/google/redirect'
		// window.location.href = '/oauth/google/oauth?token=' + response.credential
		// Here we can do whatever process with the response we want
		// Note that response.credential is a JWT ID token
		// console.log("Encoded JWT ID token: " + response.credential);
	}
	window.onload = function () {
		google.accounts.id.initialize({
			client_id: "{{ config('services.google.client_id') }}", // Replace with your Google Client ID
			callback: handleCredentialResponse // We choose to handle the callback in client side, so we include a reference to a function that will handle the response
		});
		// Enable Google "Sign-in" button
		// google.accounts.id.renderButton(document.getElementById("buttonDiv"),{ theme: "outline", size: "small" });
		google.accounts.id.prompt(); // Display the One Tap dialog
		// Hide onetap
		const button = document.querySelector('body');
		button.onclick = () => {
			google.accounts.id.disableAutoSelect();
			google.accounts.id.cancel();
		}
	}
</script>
@endif