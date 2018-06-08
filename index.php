<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <html lang="ru">
        <title>Погода в вашем городе</title>
    </head>
    <body>
        <?php
            header('Content-Type: text/html;charset=UTF-8');
            $city = 'Brest';
            $mode = 'json';
            $units = 'metric';
            $lang = 'ru';
            $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&mode=$mode&units=$units&lang=$lang&APPID=136dd864b3054232fb1d3f1b4fb94af7";
            $data = file_get_contents($url) or exit('Не удалось получить данные');
            $dataJson = json_decode($data);
            if ($dataJson === null) {
                exit('Ошибка декодирования json');
            }
            $cityJson = $dataJson->name;
            $countryJson = $dataJson->sys->country;
            $description = $dataJson->weather[0]->description;
            $temp = $dataJson->main->temp . '&#8451;';
            $pressure = $dataJson->main->pressure . " МПа";
            $humidity = $dataJson->main->humidity . " %";
            $windSpeed = $dataJson->wind->speed . ' м/с';
            $windDeg = $dataJson->wind->deg . '&deg';
            $sunriseTime = date_sunrise(time(), SUNFUNCS_RET_STRING, 52.09, 23.69, 90, 3);
            $sunsetTime = date_sunset(time(), SUNFUNCS_RET_STRING, 52.09, 23.69, 90, 3);
        ?>
        
        <table>
            <tr><th>Информация о погоде:</th></tr>
            <tr><td>Город:</td><td><?=$cityJson?></td></tr> <!--ряд с ячейками заголовков-->
            <tr><td>Страна</td><td><?=$countryJson?></td></tr> <!--ряд с ячейками тела таблицы-->
            <tr><td>Сейчас</td><td><?=date("j F Y, H:i, P")?></td></td>
            <tr><td>Погода:</td><td><?=$description?></td></tr>
            <tr><td></td><td><img src=<?='http://openweathermap.org/img/w/' . $dataJson->weather[0]->icon . '.png'?> alt="Icon depicting current weather."</td></tr>
            <tr><td>Температура:</td><td><?=$temp?></td></tr>
            <tr><td>Давление:</td><td><?=$pressure?></td></tr>
            <tr><td>Влажность:</td><td><?=$humidity?></td></tr>
            <tr><td>Скорость ветра:</td><td><?=$windSpeed?></td></tr>
            <tr><td>Направление ветра:</td><td><?=$windDeg?></td></tr>
            <tr><td>Восход солнца:</td><td><?=$sunriseTime?></td></tr>
            <tr><td>Заход солнца:</td><td><?=$sunsetTime?></td></tr>
        </table>
    </body>
</html>
