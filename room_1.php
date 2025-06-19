<?php
require_once('./dbcon.php');

try {
  $stmt = $db_connection->query("SELECT * FROM questions WHERE roomId = 1");
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
  <title>Escape Room 1</title>
  <link rel="stylesheet" href="style.css">

  <style>
    body {
      background-image: url('IMG/gunstore.png');
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
</style>

</head>

<body>
   <div class="timer-display" id="timer">05:00</div>

  <div class="container">
    <?php foreach ($questions as $index => $question) : ?>
      <!-- de php code in de class zorgt ervoor dat elke box uniek is zodat je deze apart kunt stylen. Zo krijg je dus box1, box2 en box3 -->
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
    <input type="text" id="answer" placeholder="Antwoord"><br>
    <button onclick="checkAnswer()">Antwoord</button>
    <p id="feedback"></p>
  </section>

  <script src="app.js"></script>

  <script>
  // Timer functionality - TEST VERSION (20 seconds)
let timeLeft = 5 * 60; // Changed to 20 seconds for testing
let timer;

function startTimer() {
    const timerDisplay = document.getElementById('timer');
    
    function updateDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Change warning to last 10 seconds (for testing)
        if (timeLeft <= 60) {
            timerDisplay.style.color = '#ff0000';
            timerDisplay.style.animation = 'blink 1s infinite';
        }
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