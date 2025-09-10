<?php
session_start();

// Ambil nama kota dari URL (?city=...) atau session, default "Jakarta"
$_SESSION['city'] = isset($_GET['city']) ? $_GET['city'] : ($_SESSION['city'] ?? 'Jakarta');
$city = $_SESSION['city'];

// 1. Ambil koordinat kota (lat/lon) dari Open-Meteo Geocoding API
$geo_url = "https://geocoding-api.open-meteo.com/v1/search?name=" . urlencode($city) . "&count=1";
$geo_response = file_get_contents($geo_url);

if ($geo_response === false) {
    die('Gagal mengambil data lokasi');
}

$geo_data = json_decode($geo_response, true);

if (!isset($geo_data['results'][0])) {
    die("Kota tidak ditemukan");
}

$lat = $geo_data['results'][0]['latitude'];
$lon = $geo_data['results'][0]['longitude'];

// 2. Ambil data cuaca saat ini dari Open-Meteo
$weather_url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code";
$weather_response = file_get_contents($weather_url);

if ($weather_response === false) {
    die('Gagal mengambil data cuaca');
}

$data = json_decode($weather_response, true);

if (!isset($data['current'])) {
    die("Data cuaca tidak ditemukan");
}

$currentWeather = $data['current'];

// Ambil data penting
$temp = $currentWeather['temperature_2m'];           // Suhu (°C)
$humidity = $currentWeather['relative_humidity_2m']; // Kelembapan (%)
$windspeed = $currentWeather['wind_speed_10m'];      // Angin (km/h)
$weatherCode = $currentWeather['weather_code'];      // Kode cuaca
$time = $currentWeather['time'];

// Mapping sederhana untuk icon
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
    95 => "thunder"
];
$condition = isset($iconMap[$weatherCode]) ? $iconMap[$weatherCode] : "default.svg";

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
 height:100%
}

#search-input {
  width: 5%;
  height:20%;
  margin-left:5;
  margin-top:-5%;
  float:left;
  z-index:2;
  position :relative;
}
#search-input > img {
 float:left;
 transform: scale(1.5);
 padding:0;
 margin:0;
}

button {
  float:right;
  clear:right;
  cursor: pointer;
  outline: none;
  background-color:#DDF4F8;
  width: 10%;
  height: 100px;
  margin-top:-1%;
  margin-right:5%;
  padding: 0;
  border-radius:60%;
  border:none;
  position: relative;
  overflow: hidden; 
  z-index:2; 
}
button > img{
 border: none;
 border-radius:40%;
 position: relative;
 top: 45%;
 left:40%;
 transform: translate(-50%, -50%);
 height: 70%;
 
}
.dropdown-content {
      height: 50%;
      width: 100%;
      background-color:white;
      position: absolute;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      transform: translateY(-100%);
 transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
      opacity: 0;
      pointer-events: none;
      z-index:1;
} 

.dropbtn.open + .dropdown-content {
      transform: translateY(-2%);
      opacity: 1;
      pointer-events: auto;
      z-index:1;      
    }
.dropdown-content input {
    height:35px;
    width:63%;
    font-size:50px;
    color: black;
    padding: 20px;
    text-decoration: none;
    display: block;
    border-radius:25px;
    border : 5px solid black;
    margin-top:28px; 
    margin-left:150px;
    position:relative;
    z-index:3;
    }
.dropdown-content input::placeholder{
  
   font-size:50px;

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
<div class="box-top" >
 <div class="search-container">
    <div id="search-input">
     <img src="/location.svg" alt="">
    </div>
     <button class="dropbtn">
      <img src="/search.png" alt="icon search">   
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
   <p><?php echo $temp; ?><sup> &#176;C</sup></p>
   <p><?php echo $condition; ?></p>
 </div>
</div>
<div class="box-bottom" >
 
 <div class="humidity">
  <figure style="display: flex;">
    <img src="/humidity.png" alt="" >
   <figcaption>
   <span> <?php echo $humidity;?>%</span>
   	<span>humidity</span>
   </figcaption>
  </figure>
 </div>
 <div class="wind">
  <figure style="display: flex;">
    <img src="wind.png" alt="">
    <figcaption>
    <span><?php echo $windspeed;?>Km/h</span>
    <span> wind speed</span>
    </figcaption>
  </figure>
 </div>


</div>
<script>
var dropbtn = document.querySelector(".dropbtn");

    var dropdownContent = document.querySelector(".dropdown-content");

    dropbtn.addEventListener("click", function() {
      dropbtn.classList.toggle("open");

      var isDropdownVisible = dropbtn.classList.contains("open");

      dropdownContent.style.opacity = isDropdownVisible ? 1 : 0;
      dropdownContent.style.pointerEvents = isDropdownVisible ? "auto" : "none";
    });
function updateCity() {
      const city = document.getElementById('city').value;
      fetch("", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({city})
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'ok') {
          document.getElementById('currentCity').textContent = city;
          alert("Kota diperbarui ke: " + city);
        }
      });
    }

</script>
</body>
</html>

