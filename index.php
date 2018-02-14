<?php
$appid = '8a43ceeacde9e3ff1f67525b1d2de840';
$id_default = '524894';
$city_id = isset($_REQUEST[‘city’]) ? $_REQUEST[‘city’] : $id_default;
$api = file_get_contents("http://api.openweathermap.org/data/2.5/weather?id=" . $city_id . "&appid=" . $appid);
$city_list_file = file_get_contents("city.list.json");
$decode_api = json_decode($api, true);
$decode_city = json_decode($city_list_file, true);
// Город
$city_name = $decode_api['name'];
// Погода
$weather_desc = $decode_api['weather'][0]['description'];
$pressure = $decode_api['main']['pressure'];
$humidity = $decode_api['main']['humidity'];
$coord_lon = $decode_api['coord']['lon'];
$coord_lat = $decode_api['coord']['lat'];
// Градусы
$temp = $decode_api['main']['temp'];
// Пересчитываем градусы
$temp_celsius = $temp - 273;
$temp_celsius = round($temp_celsius, 1). ' C&deg';
// Добавляем плюсик
if ($temp_celsius > 0) {
    $temp_celsius = str_pad($temp_celsius, strlen($temp_celsius)+1, "+", STR_PAD_LEFT);
}
// Иконка погоды
$icon = $decode_api['weather'][0]['icon'];
$icon_url = 'http://openweathermap.org/img/w/' . $icon . '.png';
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Домашнее задание к лекции 1.4 «Стандартные функции»</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.21/css/uikit.min.css" />
</head>
<body>
<div class="uk-container uk-margin-large-top">
    <form method="post" enctype="multipart/form-data">
        <select name="city" class="uk-select uk-form-width-medium">
            <?php foreach ($decode_city as $item) : ?>
                <option value="<?=$item['id']?>" <?php if ($item['id'] == $city_id) : echo "selected=\"selected\""; endif ?>><?=$item['name']?></option>
            <?php endforeach; ?>
        </select>
        <button class="uk-button uk-button-primary">Search</button>
    </form>
    <h1><?=$city_name;?></h1>
    <div><img src="<?= $icon_url; ?> " alt=""> <span class="uk-h2 uk-margin-small-left"><?= $temp_celsius; ?></span></div>
    <div class="uk-text-large"><?= $weather_desc; ?></div>

    <ul class="uk-list">
        <li>
            <div uk-grid class="uk-child-width-expand uk-grid-small uk-grid">
                <div class="uk-width-auto uk-first-column">
                    <span class="uk-display-block uk-text-muted">Pressure:</span>
                </div>
                <div>
                    <div>
                        <?= $pressure; ?> hpa
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div uk-grid class="uk-child-width-expand uk-grid-small uk-grid">
                <div class="uk-width-auto uk-first-column">
                    <span class="uk-display-block uk-text-muted">Humidity:</span>
                </div>
                <div>
                    <div>
                        <?= $humidity; ?> %
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div uk-grid class="uk-child-width-expand uk-grid-small uk-grid">
                <div class="uk-width-auto uk-first-column">
                    <span class="uk-display-block uk-text-muted">Geo coords:</span>
                </div>
                <div>
                    <div>
                        [<?= $coord_lat; ?>, <?= $coord_lon; ?>]
                    </div>
                </div>
            </div>
        </li>
    </ul>

</div>






<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.21/js/uikit.min.js"
        integrity="sha256-vwtRoGE4E2kxfJX4j2kIo8SjdOvvSMhg1Rbl20iCguc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.21/js/uikit-icons.min.js"
        integrity="sha256-dcB3RqnuF4+TETccGg3TtO4CvzsE2fk2nIq/feKE+jE=" crossorigin="anonymous"></script>
</body>
</html>
