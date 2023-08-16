<!DOCTYPE html>
<html>
<head>
  <style>
    .bottom-navigation {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #f1f1f1;
      padding: 10px;
    }

    .nav-button {
      background-color: transparent;
      border: none;
      outline: none;
      padding: 8px 16px;
      font-size: 16px;
      cursor: pointer;
      transition: color 0.3s;
    }

    .nav-button:hover {
      color: #333;
    }

    .indicator {
      height: 3px;
      background-color: #333;
      width: 33.33%;
      transition: transform 0.3s;
    }
  </style>
</head>
<body>
  <div class="bottom-navigation">
    <button class="nav-button" id="home-button">Home</button>
    <button class="nav-button" id="profile-button">Profile</button>
    <button class="nav-button" id="settings-button">Settings</button>
    <div class="indicator"></div>
  </div>

  <script>
    const homeButton = document.getElementById("home-button");
    const profileButton = document.getElementById("profile-button");
    const settingsButton = document.getElementById("settings-button");
    const indicator = document.querySelector(".indicator");

    homeButton.addEventListener("click", () => {
      indicator.style.transform = "translateX(0%)";
      // Add your code for the home button click functionality
    });

    profileButton.addEventListener("click", () => {
      indicator.style.transform = "translateX(100%)";
      // Add your code for the profile button click functionality
    });

    settingsButton.addEventListener("click", () => {
      indicator.style.transform = "translateX(200%)";
      // Add your code for the settings button click functionality
    });
  </script>
</body>
</html>

