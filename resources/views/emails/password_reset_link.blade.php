<!-- resources/views/emails/password_reset_link.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Link</title>
</head>
<body>
    <p>You requested a password reset. Click the link below to reset your password:</p>
    <p><a href="{{ $resetLink }}">{{ $resetLink }}</a></p>
    <p>If you did not request this, please ignore this email.</p>
</body>
</html>