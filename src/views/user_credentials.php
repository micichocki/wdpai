<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/public/css/global.css">
    <link rel="stylesheet" href="/public/css/user_credentials.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&family=Raleway:wght@800&display=swap" rel="stylesheet">
    <script src="../../public/js/user_credentials.js"></script>
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
            <li><a class="nav-text" href="logout">Logout</a></li>
        </ul>
    </nav>

    <main>

        <div class="messages">
            <?php
            if (isset($messages)) {
                foreach ($messages as $message) {
                    echo $message;
                }
            }
            ?>
        </div>
        <div class="settings-nav">
            <ul class="settings-buttons">
                <li><a href="">Personal Info</a></li>
                <li><a href="">Settings</a></li>
            </ul>
        </div>
        <div class="personal-info-container">
            <div class="welcome-text-container">
                <h1 class="welcome-text">Please provide your credentials</h1>
            </div>

            <form class="personal-info-form" method="POST">

                <label for="name">Name *</label>
                <input id="name" type="text" name="name" placeholder="Will">

                <label for="surname">Surname *</label>
                <input id="surname" type="text" name="surname" maxlength="125" placeholder="Smith">

                <label for="city">City</label>
                <input id="city" name="city" type="text" placeholder="Cracow">

                <button type="submit">Confirm</button>
            </form>
        </div>

    </main>

</body>

</html>