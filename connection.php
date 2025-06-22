<?php
$serverName = "localhost";
$userName = "root";
$password ="";
$apikey = "c6dfdc7befbb6834a1af3db387ee51d2";
$conn = mysqli_connect($serverName ,$userName , $password);
if($conn){
    // echo "connection successful <br>";
}
else{
    // echo " failed".mysqli_connect_error();
}
$createDatabase = "CREATE DATABASE IF NOT EXISTS Prototype2";
if(mysqli_query($conn , $createDatabase)){
    // echo "Database Created";
}
else{
    // echo "Failed to create".mysqli_connect_error();
}
mysqli_select_db($conn,"Prototype2");
$createTable = "CREATE TABLE IF NOT EXISTS cities (
WeatherCondition VARCHAR(50),
Temperature FLOAT NOT NULL,
Datee VARCHAR(100),
CityName VARCHAR(50) NOT NULL,
Windspeed FLOAT NOT NULL,
Humidity FLOAT NOT NULL,
DateeTime DATETIME NOT NULL
)";

if (mysqli_query($conn, $createTable)) {
// echo "Table Created";
} else {
// echo "Failed to create Table";
}

if(isset($_GET['q'])){
$CityName = $_GET['q'];
}else{
$CityName = "Siraha";
}

$selectAllData = "SELECT * FROM cities where CityName = '$CityName' ";
$result = mysqli_query($conn, $selectAllData);
$row = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result) == 0) {
$url = "https://api.openweathermap.org/data/2.5/weather?q=$CityName&appid=$apikey&units=metric";
$response = file_get_contents($url);
$data = json_decode($response, true);
$WeatherCondition = $data['weather'][0]['description'];
$Temperature = $data['main']['temp'];
$Datee = $data['dt'];
$Windspeed = $data['wind']['speed'];
$Humidity = $data['main']['humidity'];
$DateeTime = date('Y-m-d H:i:s');

$insertData = "INSERT INTO cities (WeatherCondition,Temperature, Datee, CityName, Windspeed, Humidity, DateeTime)
     VALUES ('$WeatherCondition','$Temperature', '$Datee', '$CityName','$Windspeed', '$Humidity','$DateeTime')";

if (mysqli_query($conn, $insertData)) {
    // echo "Data inserted Successfully";

} else {
    // echo "Failed to insert data" . mysqli_error($conn);

}
}
else {
$currentTimestamp = time();
$savedTimestamp = strtotime($row['DateeTime']);
$diff = $currentTimestamp - $savedTimestamp;

if($diff > 2 * 60 * 60) {
    $url = "https://api.openweathermap.org/data/2.5/weather?q=$CityName&appid=$apikey&units=metric";
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    $WeatherCondition = $data['weather'][0]['description'];
    $Temperature = $data['main']['temp'];
    $Datee = $data['dt'];
    $Windspeed = $data['wind']['speed'];
    $Humidity = $data['main']['humidity'];
    $DateeTime = date('Y-m-d H:i:s');

    $updateData = "UPDATE cities
    SET WeatherCondition='$WeatherCondition', Temperature='$Temperature',Datee='$Datee',
     Windspeed='$Windspeed', Humidity='$Humidity', DateeTime='$DateeTime' where CityName = '$CityName' ";

    if (mysqli_query($conn, $updateData)) {
        // echo "Data updated Successfully";

    } else {
        // echo "Failed to update data" . mysqli_error($conn);

    }
}
}

$result = mysqli_query($conn, $selectAllData);
$row = mysqli_fetch_assoc($result);
$json_data = json_encode($row);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo $json_data;
mysqli_close($conn);

?>