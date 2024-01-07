<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kappa | Sign In</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jomhuria&family=Raleway:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/public/css/global.css" />
  <link rel="stylesheet" href="/public/css/login.css" />
</head>

<body>
  <nav class="flex-row-left-center">
    <a href="/">
      <div class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" width="65" height="56" viewBox="0 0 65 56" fill="none">
          <path d="M0.5 0L34 27L64.5 56H0.5V0Z" fill="#7949FF" />
        </svg>

      </div>
      <div class="website-name">Kappa</div>
    </a>
    <ul class="nav-buttons-ul">
      <li><a class="nav-text" href="https://github.com/micichocki">About Us</a></li>
      <li><a class="nav-text" href="https://github.com/micichocki">Contact</a></li>
    </ul>
  </nav>

  <main class="flex-row-left-center main">
    <div class="main-content">
      <h1 class="welcome-text">It’s nice to see you again!</h1>
      <h1 class="welcome-sub-text">Please log in to begin your journey towards better education.</h1>
    </div>

    <div class="phone-container">
      <div class="phone-content">
        <div class="phone-nav-bar">
          <div class="phone-top-element"></div>
        </div>
        <div class="form-group">
          <form action="/login" id="main-from" method="POST">

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

            <div class="remember-me-container">
              <input type="checkbox" id="remember-me" name="remember-me"> <label for="remember-me" class="remember-me">Remember me</label>
            </div>

            <div class="submit-button-container">
              <input id="submit-button" type="submit" value="Sign In">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="info-container">
      <h1 class="welcome-sub-text">Please log in to begin your journey towards better education.</h1>
    </div>
  </main>
  <div class="grey-circle"></div>
</body>

</html>