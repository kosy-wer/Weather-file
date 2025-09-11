<?php
session_start();

// Ambil nama kota dari URL atau session, default Jakarta
$city = $_GET['city'] ?? $_SESSION['city'] ?? 'Jakarta';
$_SESSION['city'] = $city;

// Variabel default supaya halaman tetap render
$temp = "-";
$humidity = "-";
$windspeed = "-";
$condition = "unknown";
$errorMessage = null;

// 1. Ambil koordinat kota
$geo_url = "https://geocoding-api.open-meteo.com/v1/search?name=" . urlencode($city) . "&count=1";
$geo_response = @file_get_contents($geo_url);

if ($geo_response === false) {
    $errorMessage = "Gagal mengambil data lokasi";
} else {
    $geo_data = json_decode($geo_response, true);

    if (!isset($geo_data['results'][0])) {
        $errorMessage = "Kota tidak ditemukan!";
    } else {
        $lat = $geo_data['results'][0]['latitude'];
        $lon = $geo_data['results'][0]['longitude'];

        // 2. Ambil data cuaca
        $weather_url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code";
        $weather_response = @file_get_contents($weather_url);

        if ($weather_response === false) {
            $errorMessage = "Gagal mengambil data cuaca";
        } else {
            $data = json_decode($weather_response, true);

            if (!isset($data['current'])) {
                $errorMessage = "Data cuaca tidak ditemukan";
            } else {
                $currentWeather = $data['current'];
                $temp = $currentWeather['temperature_2m'];
                $humidity = $currentWeather['relative_humidity_2m'];
                $windspeed = $currentWeather['wind_speed_10m'];
                $weatherCode = $currentWeather['weather_code'];

                // Mapping icon sederhana
                $iconMap = [
                    0 => "clear-day",
                    1 => "mainly-clear",
                    2 => "partly-cloudy",
                    3 => "cloudy",
                    45 => "fog",
                    48 => "fog",
                    51 => "rain",
                    61 => "rain",
                    71 => "snow",
                    80 => "cloudy",
                    95 => "thunder"
                ];
                $condition = $iconMap[$weatherCode] ?? "unknown";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<style>

@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap');

/* Menggunakan font Google dengan gaya bold */
* {
  margin: 0;
  padding: 0;
}

html {
  width: 100%;
  height: 100%;
}

body {
  margin: 0;
  padding: 0;
  font-family: 'Nunito', sans-serif;
  font-weight: bold;

}

div.box-top {
  margin-top: 5%;
  height: 18vh;
  width:100%;
  
}

div.box-main{
  height: 48vh;
  display:flex;
  flex-grow:1;
  justify-content:center;
}
div.box-bottom{
  height:16vh;
  width:100%;
  display:flex;
  justify-content: space-around;
}
.box-bottom div {
 flex: 1;
 height: 140px;
 margin-left: 11%;
}

.box-weather {
  height:78%;
  width:70%;
  margin: 0 5% 0;
  display: flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  color: #333333;
  border-radius: 60px;
  box-shadow: 0px 2px 10px 1px rgba(47, 44, 42, 0.45);
}
.box-weather img{
  height:60%;
  margin-top: 1em;
}
.box-weather p:nth-child(2){
 margin : 10px 0;
 font-size:5vh;
}
.box-weather p:nth-child(3){
 margin: 10px 0;
 font-size : 4rem;	 
}

.search-form {
  width: 100%;
  height:100%;
}

.search-container {
 width:100%;
 height:100%;
 display: flex;
 flex-direction:row;
 justify-content:space-between;
 align-items:center;
 padding: 0 16px;
 box-sizing: border-box;
}

#search-input {
  width: 15%;
  aspect-ratio: 1 / 1;
  z-index:5;
}
#search-input > img {
  width: 90%;                   /* Ukuran icon 70% dari tombol */
  aspect-ratio: 1 / 1;
}
button {
  cursor: pointer;              /* Tangan saat hover */
  background-color: #DDF4F8;    /* Warna tombol */
  width: 15%;                  /* Lebar tetap */
  aspect-ratio: 1 / 1;
  border: none; 
  border-radius: 50%;           /* Bulat sempurna */
  overflow: hidden;
  display: flex;                /* Flex untuk center content */
  align-items: center;          /* Vertikal center */
  justify-content: center;      /* Horizontal center */
  z-index: 2;
}

button > img {
  width: 90%;                   /* Ukuran icon 70% dari tombol */
  aspect-ratio: 1 / 1;
}

.dropdown-content {
      height: 50%;
      width: 100%;
      background-color:white;
      position: absolute;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      transform: translateY(-100%);
      transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
      opacity: 0;
      pointer-events: none;
      z-index:5;
      display: flex;
      justify-content: center;      /* Horizontal center */
      align-items: center;          /* Vertikal center */
} 
form{
      display: flex;
      align-items: center;          /* Vertikal center */
      justify-content: center;      /* Horizontal center */
      width: 80%;
      height: 90%;
      z-index:3;

}

.dropbtn.open + .dropdown-content {
      transform: translateY(-2%);
      opacity: 1;
      pointer-events: auto;
      z-index:1;      
    }
.dropdown-content input {
    height:20%;
    width:70%;
    font-size:50px;
    color: black;
    padding: 10%;
    text-decoration: none;
    display: block;
    border-radius:25px;
    border : 5px solid black;
    position:relative;
    box-sizing: border-box;
    z-index:5;
    }
.dropdown-content input::placeholder{
  
   font-size:5%;  

}
.wind span:nth-child(2){

 margin-left:33px;
}
figure> img {
  
 height:200px;
}
span {
 margin-left:1em;
 display:block;
}

figcaption span:nth-child(1) {
 font-size:2rem;
 margin-top:50px;

}
figcaption span:nth-child(2){
 font-size:1.5rem;
 margin-top:1rem;
}
</style>

</head>
<body>
  <div class="box-top">
    <div class="search-container">
      <div id="search-input">
        <img src="../public/location.svg" alt="">
      </div>
      <button class="dropbtn">
        <img src="../public/search.png" alt="icon search">
      </button>
      <div class="dropdown-content">
        <form action="#" method="get">
          <label for="city"></label>
          <input onclick="updateCity()" type="text" id="city" name="city" value="<?php echo $city; ?>" placeholder="city..">
        </form>
      </div>
    </div>
  </div>

  <div class="box-main">
    <div class="box-weather">
      <img src="<?php echo $condition; ?>.svg" alt="Cuaca">
      <p><?php echo $temp; ?><sup>&#176;C</sup></p>
      <p><?php echo $condition; ?></p>
    </div>
  </div>

  <div class="box-bottom">
    <div class="humidity">
      <figure style="display: flex;">
        <img src="/humidity.png" alt="">
        <figcaption>
          <span><?php echo $humidity; ?>%</span>
          <span>humidity</span>
        </figcaption>
      </figure>
    </div>

    <div class="wind">
      <figure style="display: flex;">
        <img src="/wind.png" alt="">
        <figcaption>
          <span><?php echo $windspeed; ?>Km/h</span>
          <span>wind speed</span>
        </figcaption>
      </figure>
    </div>
  </div>
<?php if ($errorMessage): ?>
<script>
alert("<?php echo $errorMessage; ?>");
</script>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const dropbtn = document.querySelector(".dropbtn");
  const dropdownContent = document.querySelector(".dropdown-content");
  const cityInput = document.getElementById('city');

  // Contoh debug
  // alert("hsh"); // hapus atau aktifkan kalau perlu

  // Toggle dropdown
  dropbtn.addEventListener("click", () => {
    dropbtn.classList.toggle("open");
    const isDropdownVisible = dropbtn.classList.contains("open");
    dropdownContent.style.opacity = isDropdownVisible ? 1 : 0;
    dropdownContent.style.pointerEvents = isDropdownVisible ? "auto" : "none";
  });

  // Update city via fetch
  function updateCity() {
    const city = cityInput.value.trim();
    if (!city) return;

    fetch("", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ city })
    })
    .then(res => res.json())
    .catch(err => console.log(err));
  }

  // Jika ingin panggil dari onclick HTML
  window.updateCity = updateCity;
});
</script>

</body>
</html>

