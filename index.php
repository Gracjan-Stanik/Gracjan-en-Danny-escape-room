<?php
session_start();

// Redirect naar login als niet ingelogd
if (!isset($_SESSION["user_id"])) {
    header("Location: user/login.php");
    exit;
}

// Haal info uit sessie
$username = $_SESSION["username"];
$is_admin = $_SESSION["is_admin"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Escape Room</title>
  <link rel="stylesheet" href="style.css">

  <style>
    body {
      background-image: url('IMG/cowboy.jpeg');
      background-size: cover;
      background-position: center;
     background-repeat: no-repeat;
   }
  </style>

</head>
  
<body>

  <h1>Cowboy escape room</h1> 

  <?php if ($is_admin): ?>
    <section class="adminaccess">
      <p style="color:green;">[ADMIN ACCESS]</p>
        <a href="admin/admin_questions.php" class="btn">questions CRUD</a>
        <a href="user/add_team.php" class="btn">Team CRUD</a>
    </section>
    <?php endif; ?>

  <main>
    <!-- Escape Room Information -->
    <div class="info-box">
      <h2>Over de Escape Room</h2>
      <p>
        Welkom bij onze Escape Room! Los puzzels op, vind verborgen aanwijzingen en werk samen om binnen de tijd te ontsnappen.
        Elke kamer zit vol verrassingen. Durf jij de uitdaging aan?
      </p>
    </div>

    <!-- Test Button -->
    <a href="room_1.php" class="btn">Start het spel</a><br>
    <a href="user/logout.php" class="btn">Uitloggen</a><br>
    
    </main>

</body>

</html>