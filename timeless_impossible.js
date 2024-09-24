// získání z HTML
const scoreSpan = document.getElementById("score");
const countdownDiv = document.getElementById("countdown");
const clickableContainer = document.getElementById("clickable-container");
const countdownAll = document.getElementById("countdownAll");


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
  }, 110);
}

// Obarvení score a ukládání score do localStorage
function updatescore() {
  scoreSpan.textContent = score;
  updateLocalStorage();
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
