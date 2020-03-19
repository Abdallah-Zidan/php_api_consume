<?php
interface WeatherInterface {
    public function getCountryCities($countryCode,$filePath);
    public function getWeather($cityName,$appId);
    public function getTime();
}