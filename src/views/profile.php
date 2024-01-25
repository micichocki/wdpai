<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/public/css/global.css">
    <link rel="stylesheet" href="/public/css/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&family=Raleway:wght@800&display=swap" rel="stylesheet">
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
        <div class="nav-icons">
            <a href="dashboard">
                <svg id="home-icon" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 66 52" fill="none">
                    <path d="M26.5 51.1667V33.4167H39.5V51.1667H55.75V27.5H65.5L33 0.875L0.5 27.5H10.25V51.1667H26.5Z" fill="#7949FF" />
                </svg>
            </a>

            <a href="tutoring">
                <svg id="plus-icon" xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 49 46" fill="none">
                    <path d="M43.5556 0H5.44444C2.42278 0 0 2.3 0 5.11111V40.8889C0 43.7 2.42278 46 5.44444 46H43.5556C46.55 46 49 43.7 49 40.8889V5.11111C49 2.3 46.55 0 43.5556 0ZM38.1111 25.5556H27.2222V35.7778H21.7778V25.5556H10.8889V20.4444H21.7778V10.2222H27.2222V20.4444H38.1111V25.5556Z" fill="#7949FF" />
                </svg>
            </a>

            <a href="https://example3.com">
                <svg id="message-icon" xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 63 46" fill="none">
                    <path d="M56.7 0H6.3C2.835 0 0.0315 2.5875 0.0315 5.75L0 40.25C0 43.4125 2.835 46 6.3 46H56.7C60.165 46 63 43.4125 63 40.25V5.75C63 2.5875 60.165 0 56.7 0ZM56.7 11.5L31.5 25.875L6.3 11.5V5.75L31.5 20.125L56.7 5.75V11.5Z" fill="#7949FF" />
                </svg>
            </a>

            <a href="profile">
                <svg id="profile-icon" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 52 52" fill="none">
                    <path d="M26 26C33.1825 26 39 20.1825 39 13C39 5.8175 33.1825 0 26 0C18.8175 0 13 5.8175 13 13C13 20.1825 18.8175 26 26 26ZM26 32.5C17.3225 32.5 0 36.855 0 45.5V52H52V45.5C52 36.855 34.6775 32.5 26 32.5Z" fill="#7949FF" />
                </svg>
            </a>
        </div>
    </nav>

    <main>
        <div class="profile-main-info">
            <div class="name-credentials">
                <h1 class="username"><?= $user->getUserCredentials()->getName() ?> <?= $user->getUserCredentials()->getSurname() ?></h1>
                <h4 class="date-of-join">Joined <?= $user->getUserCredentials()->getDateOfJoin() ?></h4>
            </div>
            <div class="avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="98" height="113" viewBox="0 0 98 113" fill="none">
                    <path d="M72.6807 28.2632C72.6807 43.5275 62.0001 55.7632 48.9597 55.7632C35.9193 55.7632 25.2386 43.5275 25.2386 28.2632C25.2386 12.9988 35.9193 0.763153 48.9597 0.763153C62.0001 0.763153 72.6807 12.9988 72.6807 28.2632ZM1.01758 98.2632C1.01758 89.2721 8.82234 82.3948 18.8859 77.7344C28.91 73.0922 40.9488 70.7632 48.9597 70.7632C56.9705 70.7632 69.0094 73.0922 79.0335 77.7344C89.097 82.3948 96.9018 89.2721 96.9018 98.2632V111.763H1.01758V98.2632Z" fill="black" stroke="#7949FF" />
                </svg>
            </div>

        </div>
        <div class="settings-nav">
            <ul class="settings-buttons">
                <li><a href="">Personal Info</a></li>
                <li><a href="">Settings</a></li>
                <li><a href="">History</a></li>

            </ul>
        </div>
        <div class="personal-info-container">
            <div class='messages'>
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <form class="personal-info-form" action="#" method="POST">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="<?= $user->getEmail() ?>">

                <label for="city">City</label>
                <?php if ($user->getUserCredentials()->getCity() !== null) : ?>
                    <input id="city" type="text" name="city" maxlength="125" placeholder="<?= $user->getUserCredentials()->getCity() ?>">
                <?php else : ?>
                    <input id="city" type="text" name="city" maxlength="125">
                <?php endif; ?>

                <button type="submit">Confirm</button>
            </form>
        </div>

    </main>
    <script src="../../public/js/profile.js"></script>
</body>

</html>