<?php
require_once './WeatherInterface.php';
class Weather implements WeatherInterface {
    private $url;
    /*
     * get the cities of a specified country code  .. reads from a json file
     * @params $countryCode , $filePath
     * return array of cities names
     */
    public function getCountryCities($countryCode , $filePath) {
        $fileData = file_get_contents($filePath);
        $json = json_decode($fileData , 1);
        $result =$this->filterCities($countryCode, $json);
        return $result;
    }
    // gets the weather data of a specific city as json from the api and returns it as associative array
    public function getWeather($cityName , $appId) {
        $this->url = APIURL;
        $this->url=str_replace("{{city_name}}", $cityName, $this->url);
        $this->url = str_replace("{{app_id}}",$appId,$this->url);
        $handler = curl_init($this->url);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_FOLLOWLOCATION,1);
        $result =curl_exec($handler);
        curl_close($handler);
        $result = json_decode($result , 1);
        return $result;
    }
    public function getTime() {
        return time();
    }
    private function filterCities($code , $jsonData){
        $cities = array();
        foreach ($jsonData as $item){
            if(strtolower($item["country"]) === $code){
                $cities[] = $item["name"];
            }     
        }  
        return $cities;
    }
}
