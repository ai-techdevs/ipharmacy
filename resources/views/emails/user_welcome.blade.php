<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Donation Platform</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">

    <p>Hi {{ $name }},</p>
    <p>Thank you for your donation! An account has been created for you.</p>

    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <p>You can log in anytime and update your details.</p>

    <p>
        <a href="{{ route('login') }}" 
           style="background-color: #8EC9F4; color: #ffffff; padding: 10px 20px; 
                  text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
           Login to Your Account
        </a>
    </p>

    <p>Regards,<br>
    IPharmacy
    </p>

</body>
</html>
