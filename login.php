<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
    }

    .dropbtn {
      background-color: #4CAF50;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      position: relative;
    }

    .dropdown-content {
      height: 7vh;
      width: 100%;
      position: absolute;
      background-color: red;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      transform: translateY(-100%);
      transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
      opacity: 0;
      pointer-events: none;
    }

    .dropbtn.open + .dropdown-content {
      transform: translateY(-10%);
      opacity: 1;
      pointer-events: auto;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

  </style>
</head>
<body>
  <button class="dropbtn">Dropdown</button>
  <div class="dropdown-content">
    <a href="#">Menu 1</a>
    <a href="#">Menu 2</a>
    <a href="#">Menu 3</a>
  </div>

  <script>
    // Memilih elemen dropbtn berdasarkan class
    var dropbtn = document.querySelector(".dropbtn");

    // Memilih elemen dropdown-content berdasarkan class
    var dropdownContent = document.querySelector(".dropdown-content");

    // Menambahkan event listener untuk mengatur fungsi toggle saat dropbtn diklik
    dropbtn.addEventListener("click", function() {
      // Toggle class "open" pada dropbtn
      dropbtn.classList.toggle("open");

      // Memeriksa apakah dropdown-content sedang ditampilkan atau tidak
      var isDropdownVisible = dropbtn.classList.contains("open");

      // Mengubah opacity dan pointer-events pada dropdown-content sesuai dengan keadaan
      dropdownContent.style.opacity = isDropdownVisible ? 1 : 0;
      dropdownContent.style.pointerEvents = isDropdownVisible ? "auto" : "none";
    });
  </script>

</body>
</html>

