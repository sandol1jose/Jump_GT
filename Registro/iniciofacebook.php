<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v8.0&appId=750161119162028&autoLogAppEvents=1" nonce="QVhFriJb"></script>

<div scope="public_profile,email" onlogin="checkLoginState();" class="fb-login-button" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>

</body>
</html>


<script>
//Identificador: 750161119162028
//Clave Secreta: 7387f4f00178eb9812e378b94d078a6c

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{750161119162028}',
      cookie     : true,
      xfbml      : true,
      version    : '{v8.0}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    //statusChangeCallback(response);
  });
}

</script>
