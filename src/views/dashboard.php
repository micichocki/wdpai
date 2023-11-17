<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="/public/css/global.css" />
  </head>
  <body>
    <nav class="flex-row-center-center">
      <div>IMG</div>
      <ul class="flex-row-center-center ">
        <li>HOME</li>
        <li>ABOUT</li>
        <li>CONTACT</li>
        <li>CREATE</li>
      </ul>
    </nav>
    <main class="flex-row-center-center">
      <div class="elements">

      <?php foreach($dogs as $dog): ?>
        <div class="container">
          <img
            src="https://picsum.photos/300/200?random=1"
            alt="Placeholder Image 1"
          />
          <p>
            <?= $dog->getName(); ?>
          </p>
        </div>
      <?php endforeach; ?>


        
      </div>
      <div class="sidebar">SIDEBAR</div>
    </main>
  </body>
</html>
