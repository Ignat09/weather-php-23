<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Погода</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container text-center">
    <div class="header">
        <h1>Погода</h1>
    </div>
</div>
<div class="form-container">
    <form method="post">
        <input placeholder="Какой город искать?" type="text" name="search" id="">
        <input type="submit" name="go" value="Поиск">
    </form>
</div>
    <?php
    if (isset($_POST['go'])){
include "secret.php";
$city = $_POST['search'];
$link_to_info = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&APPID=$key";

$arr_translate = ["clear sky" => "чистое небо", "few clouds" => "небольшая облачность", "scattered clouds" => "рассеянная облачность",
    "broken clouds" => "облачно", "shower rain" => "ливень", "rain" => "дождь", "thunderstorm" => "грозовой дождь", "snow" => "снег",
    "mist" => "туман", "overcast clouds" => "пасмурно"];

$weather_info = file_get_contents($link_to_info);
$weather_info_decoded = json_decode($weather_info);
$city_name = ($weather_info_decoded->name);
$main_weather = ($weather_info_decoded->weather[0]->description);
$weather_icon = ($weather_info_decoded->weather[0]->icon);
$country_name = ($weather_info_decoded->sys->country);
$local_temp = ($weather_info_decoded->main->temp) . "°";
$local_temp_feels_like = ($weather_info_decoded->main->feels_like) . "°";
$local_humidity = ($weather_info_decoded->main->humidity) . "%"; //влажность
$local_wind_speed = ($weather_info_decoded->wind->speed) . "м/с";
$local_pressure = round(($weather_info_decoded->main->pressure) / 1.333) . "мм.рт.ст";

$card_with_weather = "
<div class=\"card-container\">
<div class=\"container\">
<h2>Результат:</h2>
</div>
<div class=\"card\" style=\"width: 18rem;\">
<img src=\"https://openweathermap.org/img/wn/$weather_icon.png\" class=\"card-img-top\" alt=\"...\">
<div class=\"card-body\">
  <h3 class=\"card-title\">$city_name, $country_name</h3>
  <h3 class=\"card-title\">$arr_translate[$main_weather]</h3>
  <h5 class=\"card-text\">Температура воздуха: $local_temp</h5>
  <h6 class=\"card-text\">ощущается как $local_temp_feels_like</h6>
  <h5 class=\"card-text\">Влажность воздуха: $local_humidity</h5>
  <h5 class=\"card-text\">Скорость ветра: $local_wind_speed</h5>
  <h5 class=\"card-text\">Атмосферное давление: $local_pressure</h5>
</div>
</div>
</div>";

// print_r($weather_info_decoded);
print $card_with_weather;
// print "Название города: $city_name";
// print_r($weather_info_decoded->name)
//<a href=\"#\" class=\"btn btn-primary\">Go somewhere</a>
    }
?>
<?php

?>
</body>
</html>

