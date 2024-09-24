  //Převedení do HTML
  const modeCheckboxes = document.getElementsByName("mode");
  const difficultyCheckboxes = document.getElementsByName("difficulty");
  const startButton = document.getElementById("start-button");
  const highestScoreEasyDiv = document.getElementById("highest-score-easy");
  const highestScoreMediumDiv = document.getElementById("highest-score-medium");
  const highestScoreHardDiv = document.getElementById("highest-score-hard");
  const highestScoreImpossibleDiv = document.getElementById("highest-score-impossible");

  //Checkboxes
  function handleCheckboxClick() {
    let modeChecked = false;
    let difficultyChecked = false;

    // Pravidla pro Start
    for (const element of modeCheckboxes) {
      if (element.checked) {
        modeChecked = true;
        break;
      }
    }

    for (const element of difficultyCheckboxes) {
      if (element.checked) {
        difficultyChecked = true;
        break;
      }
    }

    // Zjištěění pravidel start buttonu
    if (modeChecked && difficultyChecked) {
      startButton.disabled = false;
    } else {
      startButton.disabled = true;
    }
  }

  // Spuštění Start buttonu
  for (const element of modeCheckboxes) {
    element.addEventListener("click", handleCheckboxClick);
  }

  for (const element of difficultyCheckboxes) {
    element.addEventListener("click", handleCheckboxClick);
  }

  // Event Lister
  startButton.addEventListener("click", function() {
    let modeValue = "";
    let difficultyValue = "";

    // Zjištění modu
    for (const element of modeCheckboxes) {
      if (element.checked) {
        modeValue = element.value;
        break;
      }
    }

    // Zjištění obtížnosti
    for (const element of difficultyCheckboxes) {
      if (element.checked) {
        difficultyValue = element.value;
        break;
      }
    }

    // Vytvoření HTML
    let gameUrl = modeValue + "_" + difficultyValue + ".html";

    // Převenední na jiné HTML
    window.location.href = gameUrl;
  });


  
