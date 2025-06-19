// Global variables
let completedQuestions = [];
let timeLeft = 5 * 60; // 5 minutes in seconds
let timer;

// Initialize the application
function init() {
    startTimer();
    setupEventListeners();
}

// Start the countdown timer
function startTimer() {
    const timerDisplay = document.getElementById('timer');
    
    function updateDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Change color when time is running low
        if (timeLeft <= 60) { // Last minute
            timerDisplay.style.color = 'red';
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

// Setup event listeners
function setupEventListeners() {
    // Handle Enter key in answer input
    document.getElementById('answer').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            checkAnswer();
        }
    });
}

// Open modal with question
function openModal(index) {
    let box = document.querySelector(`.box[data-index='${index}']`);
    let questionText = box.dataset.question;
    let correctAnswer = box.dataset.answer;

    document.getElementById('question').innerText = questionText;
    document.getElementById('modal').dataset.answer = correctAnswer;
    document.getElementById('modal').dataset.currentIndex = index;
    document.getElementById('answer').value = '';
    document.getElementById('feedback').innerText = '';

    document.getElementById('overlay').style.display = 'block';
    document.getElementById('modal').style.display = 'block';
    
    // Focus on answer input
    document.getElementById('answer').focus();
}

// Close modal
function closeModal() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('modal').style.display = 'none';
    document.getElementById('feedback').innerText = '';
}

// Check if answer is correct
function checkAnswer() {
    let userAnswer = document.getElementById('answer').value.trim();
    let correctAnswer = document.getElementById('modal').dataset.answer;
    let currentIndex = document.getElementById('modal').dataset.currentIndex;
    let feedback = document.getElementById('feedback');

    if (userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
        feedback.innerText = 'Correct! Goed gedaan!';
        feedback.style.color = 'green';
        
        // Mark question as completed
        if (!completedQuestions.includes(currentIndex)) {
            completedQuestions.push(currentIndex);
            document.querySelector(`.box[data-index='${currentIndex}']`).style.backgroundColor = '#2ecc71'; // Green for completed
        }
        
        // Check if all questions are completed
        if (completedQuestions.length === document.querySelectorAll('.box').length) {
            // Stop the timer
            clearInterval(timer);
            
            // All questions answered - proceed to next room
            setTimeout(() => {
                window.location.href = getNextRoomUrl();
            }, 1000);
        } else {
            setTimeout(closeModal, 1000);
        }
    } else {
        feedback.innerText = 'Fout, probeer opnieuw!';
        feedback.style.color = 'red';
        
        // Penalty for wrong answer (optional)
        timeLeft = Math.max(0, timeLeft - 10); // Subtract 10 seconds
    }
}

// Determine next room URL
function getNextRoomUrl() {
    const currentPage = window.location.pathname.split('/').pop().replace('.php', '');
    
    if (currentPage === 'room_1') return 'room_2.php';
    if (currentPage === 'room_2') return 'win.php';
    return 'index.php'; // fallback
}

// Initialize the app when DOM is loaded
document.addEventListener('DOMContentLoaded', init);