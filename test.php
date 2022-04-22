<?php
 $url = "https://api.openweathermap.org/data/2.5/forecast?q=a&units=metric&appid=1769a0e8ed5ea4801ff166c1f8609a51";
 $headers = get_headers($url, 1);
 echo $headers[0];
?>