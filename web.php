<?php
session_start();
// Set nilai default jika sesi kosong

$_SESSION['city'] = isset($_GET['city']) ? $_GET['city'] : ($_SESSION['city'] ?? "Jakarta");

$city =$_SESSION['city'];
$apiKey = 'QK2S4CHL8XBMTSVPDJVXPVGSY';
$endpoint = 'https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/'.urlencode($city).'?unitGroup=metric&key=' . $apiKey . '&contentType=json';

// Mengambil data cuaca dari API
$response = file_get_contents($endpoint);

// Memastikan permintaan berhasil
if ($response === false) {
    die('Gagal mengambil data cuaca');
}

// Menguraikan respons JSON                                                                                                                 

$data = json_decode($response, true);

// Memeriksa apakah ada kesalahan dalam respons
if (isset($data['errorCode'])) {
    die('Terjadi kesalahan: ' . $data['errorCode'] . ' - ' . $data['message']);
}

// Mengambil data cuaca hari ini
$todayWeather = $data['days'][0];

// Mendapatkan informasi cuaca
$temp = $todayWeather['temp'];
$humidity = $todayWeather['humidity'];
$windspeed = $todayWeather['windspeed'];
$conditions = $todayWeather['conditions'];
$icon = $todayWeather['icon'];
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
       <input type="text" id="city" name="city" value="jakarta" placeholder="city..">
</form>
     </div>
 </div>
</div>
<div class="box-main">
 <div class="box-weather">
 <img src="/<?php echo $icon; ?>.svg" alt="<?php echo $icon; ?>">
   <p><?php echo $temp; ?><sup> &#176;C</sup></p>
   <p><?php echo $conditions ?></p>
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

