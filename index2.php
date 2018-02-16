<?php
function mb_ucfirst($string, $enc = 'UTF-8')
{
    return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) .
        mb_substr($string, 1, mb_strlen($string, $enc), $enc);
}
$city_id = '554234';
$api_id = '4d192b3d288c9fe66792b4a1140e6a3d';
$units_format = 'metric'; //metric(celcius, meter/sec), imperial(farenheit, miles/hour), default(Kelvin, meter/sec)
$lang = 'ru';
$api = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id=' . $city_id . '&units=' . $units_format . '&lang=' . $lang . '&APPID=' . $api_id);
//Взяты данные из сервиса только
$decode_api = json_decode($api, true);
$icon = $decode_api['weather'][0]['icon'];
$icon_url = 'http://openweathermap.org/img/w/' . $icon . '.png';
$city_name = $decode_api['name'];
$weather_descr = $decode_api['weather'][0]['description'];
$temp = round($decode_api['main']['temp'], 1);
$pressure = ceil(($decode_api['main']['pressure']) * 0.7500616827); //перевод из гектопаскалей в мм.рт.ст.
$humidity = $decode_api['main']['humidity'];
$wind_speed = $decode_api['wind']['speed'];
$time_of_messure = date("d.m.Y - H:i", $decode_api['dt']);
$weather_descr = mb_ucfirst($weather_descr);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>1-4</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<div class="container">
    <header>
        <div class="city">
            <h1> <?= $city_name ?> </h1>
            <h2> <?= $time_of_messure ?> </h2>
        </div>
        <div class="wrap-temp">
            <figure class="icon">
                <img src="<?= $icon_url ?>" alt="<?= $weather_descr ?>">
                <figcaption>
                    <p class="temp" ><?= $temp ?>&deg;C</p>
                    <p class="descr"><?= $weather_descr ?></p>
                </figcaption>
            </figure>
        </div>
    </header>
    <table>
        <tr>
            <th>Влажность:</th>
            <td> <?= $humidity ?> % </td>
        </tr>
        <tr>
            <th>Давление:</th>
            <td> <?= $pressure ?> мм.рт.ст </td>
        </tr>
        <tr>
            <th>Скорость ветра:</th>
            <td> <?= $wind_speed ?> м/с </td>
        </tr>
    </table>
</div>

</body>
</html