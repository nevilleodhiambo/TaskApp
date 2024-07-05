<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <p>Hello,</p>
    <p>We have sent you this email to check if this email: <a href="#">{{$user->email}}</a> you provided is a valid one. Click on the link to verify:</p>
    <p><a href="{{ route('verify.email', $user->remember_token) }}">Check my email</a></p>
</body>
</html>
