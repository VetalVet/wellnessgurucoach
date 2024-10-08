<!-- email-template.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        
    .email-container {
      font-family: Arial, sans-serif;
      background-color: #FAF9F6;
      max-width: 600px;
      margin: 0 auto;
    }

    .email-header {
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      padding-left: 20px;
      background-color: #f0eee6;
      height: 120px;
    }

    .email-content {
      margin: 30px;
    }

    .email-content p {
      margin: 10px 0;
    }

    .email-footer {
      margin-top: 20px;
      text-align: center;
      font-size: 0px;
      color: #777;
      background-color: #f0eee6;
      padding: 10px 20px;
      height: 60px;
    }

    .line {
      height: 2px;
      background-color: #37B048;
      margin: 20px 0;
    }

    @media (max-width: 400px) {
      .email-container {
        max-width: none;
      }
      .email-header {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        padding-left: 20px;
        background-color: #f0eee6;
        height: 90px;
      }
    }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='email-header'>
            <a href="https://wellnessgurucoach.com/" style="float: left; max-width: 50%; padding: 20px 0;">
                <img width="206" height="75" style="width: 100%;height: 100%;" src="https://wellnessgurucoach.com/wp-content/uploads/2024/09/logo-2.svg" alt="">
            </a>

            <div class="header_image" style="float: right; max-width: 40%; width: 100%;height: 100%;">
                <img style="width: 100%;height: 100%;" src="https://wellnessgurucoach.com/wp-content/uploads/2024/09/image-13.jpg" alt="">
            </div>
        </div>

        <div class="line"></div>

        <div class='email-content'>
            <h3 style="text-align: center;">New Booking</h3>
            {{content}}
        </div>

        <div class="line"></div>

        <div class='email-footer'>
            <a style="float: left; margin-top: 9px;" href="https://wellnessgurucoach.com/">
                <img width="104" height="38" src="https://wellnessgurucoach.com/wp-content/uploads/2024/09/logo-1.svg" alt="">
            </a>

            <div style="float: right; margin-top: 17px;" class="socials">
                <a href="https://www.instagram.com/marina_wellnessguru/">
                    <img width="25" height="25" src="https://wellnessgurucoach.com/wp-content/uploads/2024/10/vector.svg" alt="">
                </a>
                <a style="margin-left: 10px;" href="https://www.facebook.com/marina.vaysbaum">
                    <img width="25" height="25" src="https://wellnessgurucoach.com/wp-content/uploads/2024/10/fa-brands_facebook.svg" alt="">
                </a>
            </div>
        </div>
    </div>
</body>
</html>
