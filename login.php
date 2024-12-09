<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form | CodingLab</title> 
    <link rel="stylesheet" href="style_reg.css">
  </head>
<body>
  <div class="wrapper">
    <h2>Login</h2>
    <form action="#">
      <div class="input-box">
        <input type="text" id="user_name" name="user_name" autocomplete="off" placeholder="Enter your username" required>
      </div>
      <div class="input-box">
        <input type="password" id="user_password" name="user_password" autocomplete="off" placeholder="Enter your password" required>
      </div>
      <div class="input-box button">
        <input type="Submit" value="Login Now">
      </div>
      <div class="text">
        <h3>Don't have an account? <a href="register.php">Register now</a></h3>
      </div>
    </form>
  </div>
</body>
</html>
