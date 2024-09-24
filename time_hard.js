// věci z HTML
const scoreSpan = document.getElementById("score");
const countdownDiv = document.getElementById("countdown");
const timerDiv = document.getElementById("timer");
const clickableContainer = document.getElementById("clickable-container");
const countdownAll = document.getElementById("countdownAll");
const scoreModal = document.getElementById("scoreModal");
const finalScore = document.getElementById("finalScore");
const goToMenuButton = document.getElementById("goToMenu");

// proměnné
let score = 0;
let timeLeft = 60;
let count = 3;

// disable increase button bělem countdownu
clickableContainer.disabled = true;

// start countdownu
countdownDiv.textContent = count;

const countdownInterval = setInterval(() => {
    count--;
    if (count >= 0) {
        countdownDiv.textContent = count;
    } else {
        clearInterval(countdownInterval);
        countdownDiv.style.display = "none";
        countdownAll.style.display = "none";

        scoreSpan.textContent = score;
        startScoreDecrease();
        clickableContainer.disabled = false;

            // Start timer
            const timerInterval = setInterval(() => {
            timeLeft--;
            timerDiv.textContent = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                clickableContainer.disabled = true;
                clearInterval(decreaseInterval);
                finalScore.textContent = `Your final score is: ${score}`;
                scoreModal.style.display = "block";
                sendScoreToServer(score);
            }
        }, 1000);
    }
}, 1000);

// Automatický decrease
let decreaseInterval;
function startScoreDecrease() {
    decreaseInterval = setInterval(() => {
        score--;
        updatescore();
    }, 130);
}

// Obarvení score a ukládání score do localStorage
function updatescore() {
    scoreSpan.textContent = score;
    if (score < 0) {
        scoreSpan.style.color = "red";
    } else if (score > 0) {
        scoreSpan.style.color = "green";
    } else {
        scoreSpan.style.color = "black";
    }
}

// Increase button
document.addEventListener("click", () => {
    if (!clickableContainer.disabled && count < 0) {
        score++;
        updatescore();
    }
});

// Send score to server
function sendScoreToServer(finalScore) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_score.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Score saved successfully");

            // Zpátky to menu
            goToMenuButton.addEventListener("click", () => {
                window.location.href = "menu.php";
            });
    
            // Zůstání na stránce
            document.querySelector(".close").onclick = function() {
                scoreModal.style.display = "none";
            };
        } else {
            console.error("Error saving score");
        }
    };
    xhr.send("score=" + finalScore + "&mode=time_hard");
}

goToMenuButton.addEventListener("click", () => {
    window.location.href = "menu.php";
});

document.querySelector(".close").onclick = function() {
    scoreModal.style.display = "none";
};