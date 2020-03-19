<?php
// change ini file settings to allow unlimited memory for the script as it only allows 4 mb per script
ini_set("memory_limit", '-1');
require_once './Weather.php';
require_once './config.php';
// object of weather class
$weather = new Weather();
// get egyptian cities by passing "eg" as country code and the path of the json file from config.php
$egyptianCities = $weather->getCountryCities("eg", FILEPATH);
?>

<html>
<head>
    <title>Weather Data</title>
</head>
<body>
<form id="form" action="" method="POST">
    <select name="city">
        <?php
        // loop theough the cities array and create an option for each city in the select
        foreach ($egyptianCities as $city) {
            echo "<option value='$city'>Eg >> '$city'</option>";
        }
        ?>
    </select>
    <input id="submit" name="submit"  type="submit" value="get data">
</form>
<?php
// check if submit button is clicked or not and city value not null
if (isset($_POST["submit"]) && isset($_POST["city"])) {
   // get the selected city name from the form posted data using the superglobal array $_POST
    $selectedCity = ($_POST["city"]);
    // get weather data as associative array using get wearther method and pass the city name and app id
    $data = $weather->getWeather($selectedCity,APP_ID);
    // get the current time in the desired format
    $time = date("F d, Y h:i:s A", $weather->getTime());
    // getting some specific data from the whole returned weather data
    $weatherState = $data["weather"][0]["description"];
    $humidity = $data["main"]["humidity"];
    $speed = $data["wind"]["speed"];
    // prepare the html text to be displayed on the browser
    $html = "<h3>$selectedCity weather status today.</h3>  <h4> $time </h4><h4>$weatherState</h4> <h4>humidity : $humidity</h4> <h4>wind speed : $speed km/hr</h4>";
    echo $html;
}
?>

</body>
</html>
