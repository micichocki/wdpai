<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kappa | Sign Up</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jomhuria&family=Raleway:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/public/css/global.css" />
  <link rel="stylesheet" href="/public/css/register.css" />
  <script src="../../public/js/register.js"></script>
</head>

<body>
  <nav class="flex-row-left-center">
    <a href="<?php echo isset($_SESSION['user_id']) ? '/dashboard' : '/'; ?>">
      <div class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" width="65" height="56" viewBox="0 0 65 56" fill="none">
          <path d="M0.5 0L34 27L64.5 56H0.5V0Z" fill="#7949FF" />
        </svg>
      </div>
      <div class="website-name">Kappa</div>
    </a>
    <ul class="nav-buttons-ul">
      <li><a class="nav-text" href="https://github.com/micichocki">Contact</a></li>
    </ul>
  </nav>

  <main class="flex-row-left-center main">
    <div class="main-content">
      <h1 class="welcome-text">Welcome to the tutoring appointment scheduling platform!</h1>
      <h1 class="welcome-sub-text">You already have an account? <a class="click-here" href="/login">Click here</a></h1>
    </div>

    <div class="phone-container">
      <div class="phone-content">
        <div class="phone-nav-bar">
          <div class="phone-top-element"></div>
        </div>
        <div class="form-group">
          <form id="main-from" method="POST">

            <div class="messages">
              <?php
              if (isset($messages)) {
                foreach ($messages as $message) {
                  echo $message;
                }
              }
              ?>
            </div>

            <label for="email">e-mail</label>
            <input type="email" id="email" name="email">

            <label for="password">password</label>
            <input type="password" id="password" name="password">

            <label for="retype-password">retype password</label>
            <input type="password" id="retype-password" name="retype-password">

            <div class="submit-button-container">
              <input id="submit-button" type="submit" value="Sign Up">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="info-container">
      <h1 class="welcome-sub-text">You already have an account? <a class="click-here" href="login">Click here</a></h1>
    </div>
  </main>

  <div class="grey-circle"></div>
</body>

</html>