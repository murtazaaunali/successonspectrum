<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Admission Form</title>
</head>

<body>
	
	
	<h3 style="font-size: 30pt; color:#073763;"><img width="25" src="{{ asset('assets/images/email_image.png') }}" />{{ $name }}</h3>
	<p>WELCOME TO SUCCESS OF SPECTRUM!</p>
	
	<p style="color:#555">Here you can login SOS PORTHOLE</p>
	<p style="color:#555">
		Email: {{ $email }}<br/>
		Password: {{ $password }}<br/>
	</p>
	<p style="color:#555">Visit: <a href="{{ $link }}">http://sosapp.accunity.com</a></p>
</body>
</html>