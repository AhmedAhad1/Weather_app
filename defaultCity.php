
<?php

$city = "Dhaka" ; 
  $url = "https://api.openweathermap.org/data/2.5/forecast?q=$city&units=metric&appid=1769a0e8ed5ea4801ff166c1f8609a51";
  
  $current_weather = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=1769a0e8ed5ea4801ff166c1f8609a51";
  
  $current_content = file_get_contents($current_weather);
  $contents = file_get_contents($url);
  $clima = json_decode($contents);
  $clima_now = json_decode($current_content);
  $cod =$clima_now->cod;

  $temp_now = $clima_now->main->temp;
  $city_name = $clima_now->name;
  $country_name = $clima_now->sys->country;
  $current_weather = $clima_now->weather[0]->main;
  $feels_like = $clima_now->main->feels_like;
  $current_windSpeed=$clima_now->wind->speed;
  $current_min_temp=$clima_now->main->temp_min;
  $current_max_temp=$clima_now->main->temp_max;
  $country_fullName =countryCodeToCountry($country_name);
  $current_icon=$clima_now->weather[0]->icon;  

  $epoch = $clima_now->dt;
$dt = new DateTime("@$epoch");
$dt =$dt->format('Y-m-d H:i:s');   
 
$timeOffset = $clima_now->timezone;
    
$timezone = $timeOffset/3600;

if($timezone>0){
  $timezone = '+'.$timezone.':00';
}
elseif($timezone<0){
  $timezone =$timezone.':00';
}
$t = new DateTime($dt,new DateTimeZone('UTC'));
$t->setTimezone(new DateTimeZone($timezone));
$weather_time=$t->format('h:i');




// 5 day forecast

$date_array = [];
$length = count($clima->list);
for($i=0; $i<$length;$i++){
  $date_array[$i] = $clima->list[$i]->dt_txt;
  $date_array[$i] = strtotime($date_array[$i]);
  $date_array[$i] = date('d-m-y',$date_array[$i]);
  
}



$date_array = (array_unique($date_array));
$array_keys = array_keys($date_array);







  ?>