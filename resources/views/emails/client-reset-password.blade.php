<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <p>Hello,</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Click the link below to reset your password:</p>
    <a href="{{ url('password/reset', $token) }}">Reset Password</a>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Best Regards,</p>
    <p>Microfinance Solution Support team</p>
</body>
</html>
