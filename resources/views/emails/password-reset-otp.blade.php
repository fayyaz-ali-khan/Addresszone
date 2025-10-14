<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 8px;
            margin: 30px 0;
            color: #2c5aa0;
            background-color: #f0f5ff;
            padding: 15px;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #777777;
            text-align: center;
        }
        .warning {
            background-color: #fff8e6;
            padding: 10px 15px;
            border-left: 4px solid #ffb100;
            font-size: 14px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <!-- Replace with your logo -->
        <img src="https://yourcompany.com/logo.png" alt="[Your Company Name]" class="logo">
        <h1>Password Reset Request</h1>
    </div>

    <p>Hello {{$name}},</p>

    <p>We received a request to reset the password for your [Your Company Name] account associated with this email address.</p>

    <p>Please use the following One-Time Password (OTP) to complete your password reset:</p>

    <!-- The OTP Code -->
    <div class="otp-code">{{$otp}}</div> <!-- Replace [123 456] with the dynamic OTP -->

    <p>This code is valid for the next <strong>[10] minutes</strong>. Please do not share it with anyone.</p>

    <div class="warning">
        <strong>Didn't request this?</strong> If you did not request a password reset, please ignore this email. Your account remains secure. For safety, we recommend reviewing your account security settings.
    </div>

    <p>If you are having trouble with the OTP or did not make this request, please contact our support team at <a href="mailto:support@yourcompany.com">support@yourcompany.com</a>.</p>

    <p>Best regards,<br>The [Your Company Name] Team</p>

    <div class="footer">
        <p>&copy; [Current Year] [Your Company Name]. All rights reserved.</p>
        <p>[Your Company Address, City, State, Zip Code]</p>
        <p>
            <a href="https://yourcompany.com/privacy">Privacy Policy</a> |
            <a href="https://yourcompany.com/terms">Terms of Service</a>
        </p>
    </div>
</div>
</body>
</html>
