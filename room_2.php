<?php
require_once('./dbcon.php');

try {
  $stmt = $db_connection->query("SELECT * FROM questions WHERE roomId = 2");
  $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Databasefout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Escape Room 2</title>
  <link rel="stylesheet" href="style.css">
</head>

<style>
    body {
      background-image: url('IMG/saloon.png');
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
</style>
<body>
   <div class="timer-display" id="timer">05:00</div>

  <div class="container">
    <?php foreach ($questions as $index => $question) : ?>
    <div class="box box<?php echo $index + 1; ?>" onclick="openModal(<?php echo $index; ?>)"
      data-index="<?php echo $index; ?>" data-question="<?php echo htmlspecialchars($question['question']); ?>"
      data-answer="<?php echo htmlspecialchars($question['answer']); ?>">
      Box <?php echo $index + 1; ?>
    </div>
    <?php endforeach; ?>
  </div>

  <section class="overlay" id="overlay" onclick="closeModal()"></section>

  <section class="modal" id="modal">
    <h2>Escape Room Vraag</h2>
    <p id="question"></p>
    <input type="text" id="answer" placeholder="Typ je antwoord">
    <button onclick="checkAnswer()">Verzenden</button>
    <p id="feedback"></p>
  </section>

  <script src="app.js"></script>
  <script>
    // Timer functionality
    const timeLimit = 5 * 60; // 5 minutes in seconds
    let timeLeft = timeLimit;
    let timer;

    function startTimer() {
      const timerDisplay = document.getElementById('timer');
      
      function updateDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
      }
      
      updateDisplay();
      
      timer = setInterval(() => {
        timeLeft--;
        updateDisplay();
        
        if (timeLeft <= 0) {
          clearInterval(timer);
          window.location.href = 'lose.php';
        }
      }, 1000);
    }

    // Start timer when page loads
    window.onload = startTimer;
  </script>

</body>

</html>