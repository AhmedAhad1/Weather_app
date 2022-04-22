


<?php
include "countryCode.php";
$error = false;
if(isset($_POST['search'])){

  $city = $_POST['city'];  
  $url = "https://api.openweathermap.org/data/2.5/forecast?q=$city&units=metric&appid=1769a0e8ed5ea4801ff166c1f8609a51";
  
  $current_weather = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=1769a0e8ed5ea4801ff166c1f8609a51";
  

  $headers = get_headers($url, 1);
 if ($headers[0]=="HTTP/1.1 404 Not Found"){
   $error = true;

   
 }
else{

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

//if reads


 
  
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



}

}
else{
  
include "defaultCity.php";
}
    
       ?>
<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='UTF-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <link
      href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'
      rel='stylesheet'
      integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC'
      crossorigin='anonymous'
    />
    <link rel='stylesheet' href='style.css' />

<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>

<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>

<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css"
  rel="stylesheet"
/>
    <!-- links -->
    <title>Document</title>
  </head>
  <?php
  $img_url= "https://source.unsplash.com/1600x900/?$current_weather";
  echo"<body class='text-light' style= ' background-image:linear-gradient(
    to right bottom,
    rgba(61, 52, 52, 0.356),
    rgb(20, 18, 18)
  ), url($img_url);background-size: cover;
  background-repeat: no-repeat;'>";
  ?>

    <div
      class='container-fluid min-vh-100 p-0 d-flex flex-column justify-content-between'
    >
  <div class='search-box p-3' >
  <form action='' method='post'>   
    <div class="input-group">
    <div class="form-outline">
    <input type="city" id="form1" name='city'class="form-control" placeholder="Enter City Name" required/>
    <label class="form-label text-light" for="form1">Search</label>
  </div>
  <button type="submit" name='search'class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button>
</div>
        </form>
      </div>

<?php

if ($error == true){
  echo ' <div class="d-flex flex-column justify-content-center align-items-center min-vh-100" >
  <div class="alert alert-primary d-flex align-items-center" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>
  <div>
    Stop testing my abilities. Invalid city dude 😎
  </div>
</div>
</div>';
  return 0;
}
?>

      <div class='current-temp px-5'>
        <div
          class='top-view d-md-flex justify-content-around align-items-center'
        >
          <div class='time'>
            <?php
            
            echo " <span class='display-1'>$weather_time</span>
            <span>{$t->format('a')}</span>
            
           
            
            <p class='display-5'>{$t->format('l, d F')}</p>
          </div>
          
          <p class='display-4'>$city_name, $country_fullName </p>";
          
          ?>
        </div>
       <div class="row">
         <div class="col-md"></div>
         <div class="col-md-8">
        <?php
        echo"<div class='weather-elements text-center '>
          <img src='http://openweathermap.org/img/wn/$current_icon@2x.png' alt='' />
          <p class='display-5'>$temp_now&deg;C</p>

          <p> {$clima_now->weather[0]->description}</p>
          <div class='min-temp  '>
            <span>Minimum temperature: </span>
            <span>$current_min_temp &deg;C</span>
          </div>
          <div class='max-temp'>
            <span>Maximum temperature: </span>
            <span>$current_max_temp &deg;C</span>
          </div>
          <div class='feels-like'>
            <span>Feels Like: </span>
            <span>$feels_like &degC</span>
          </div>
          <div class='humidity'>
            <span>humidity: </span>
            <span>{$clima_now->main->humidity}%</span>
          </div>
          <div class='pressure'>
            <span>Pressure: </span>
            <span>{$clima_now->main->pressure} hPa</span>
          </div>
          <div class='wind-speed'>
            <span>Wind Speed: </span>
            <span>$current_windSpeed m/s</span>
          </div>
        </div>
        </div>"
        ?>
        <div class="col-md"></div>
        </div>
      </div>
      <section class='future-forecast-section mt-5'>
        <div class='future-forecast d-md-flex gap-3 justify-content-center'>

<?php

for($i=0;$i<count($array_keys);$i++){


 $temp= $clima->list[$array_keys[$i]]->main->temp;
 $icon = $clima->list[$array_keys[$i]]->weather[0]->icon;
 $humidity_future = $clima->list[$array_keys[$i]]->main->humidity;
 $future_weather = $clima->list[$array_keys[$i]]->weather[0]->main;
  //  $clima->list[$array_keys[$i]]->dt_txt;

   $epoch = $clima->list[$array_keys[$i]]->dt;
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
   $weather_time=$t->format('l');







  echo"<div class='day text-center'>
            <img src='http://openweathermap.org/img/wn/$icon@2x.png' alt='' />
            <div class='forecast-elements'>
            <p class ='forecast-day'>$weather_time</p>
            <p class='text-center'>$future_weather</p>
              <p class='text-center'>$temp &deg;C</p>
              <p class='text-center'>Humidity $humidity_future %</p>
            </div>
          </div>";

}


?>

      </section>
    </div>

    <!-- script -->

<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"
></script>
    <script
      src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'
      integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM'
      crossorigin='anonymous'
    ></script>
  </body>
</html>
