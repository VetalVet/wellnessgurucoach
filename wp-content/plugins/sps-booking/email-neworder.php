<!-- email-template.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
        }
        .email-header {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .email-content {
            margin-top: 20px;
        }
        .email-content p {
            margin: 10px 0;
        }
        .email-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class='email-container'>
    <div class='email-header'>New Booking</div>
    <div class='email-content'>
        <!-- Тут буде ваш контент -->
        {{content}}
    </div>
    <div class='email-footer'>This email was sent from your website.</div>
</div>
</body>
</html>
