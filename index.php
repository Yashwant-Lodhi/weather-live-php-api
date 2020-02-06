<?php

    $city = '';
   
    $temp = '-';
    $weather = '-';
    $humidity = '-';
    $clouds = '-';
    $wind_speed = '-';
    $update_time = '-';
    $country = '';
    $flag_icon = '';
    $error = '';

    if (isset($_POST['city']) && $_POST['city'] != '') {

    $city = ucwords($_POST['city']);
    
    // $api = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q='.$city.'&APPID=8438ec758fdb93bcf1ec7b31a533c65c');
    
    $ch = curl_init();
 
        // set url
        curl_setopt($ch, CURLOPT_URL, 'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&APPID=8438ec758fdb93bcf1ec7b31a533c65c');
 
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
        // $output contains the output string
        $api = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch); 
    
    $api_array = json_decode($api, true);
    
    if ($api_array['cod'] == '200') {
        
    $weather = $api_array['weather'][0]['description'];

    $temp = $api_array['main']['temp'] - (273.15);

    $humidity = $api_array['main']['humidity'];
    $clouds = $api_array['clouds']['all'];
    $wind_speed = $api_array['wind']['speed'];

    $update_time = $api_array['dt'];
    $update_time = gmdate('d-m-y h:i T', $update_time);

    $country = $api_array['sys']['country'];
    $flag_icon = strtolower($api_array['sys']['country']);
    
    } else {
        $error = '<div class="text-warning h2">No City Found with Name : </br> "<span class="text-danger font-weight-bold text-uppercase">'.$city.'</span>"</div>';
    }
    
    
    
}
else {
    $city = '<span class="text-warning">No City Selected</span>';
}
?>

<!doctype html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Live Weather Status</title>
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:400,700" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <style>
    
            
            body {
            font-family: 'Barlow Semi Condensed', sans-serif;
            background: radial-gradient(rgba(0,0,0,.5), rgba(0,0,0,.7)), url(bg.png);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            scroll-behavior: smooth;
        }

    
    </style>

  </head>
  <body>
        <div class="container">
            <div class="row justify-content-center align-items-center py-5 my-md-0" style="height: 96vh;">
                <div class="col-md-6">
                    <div class="pt-5 pt-md-0">
                        <h1 class="text-light display-3 mb-3 font-weight-bold">Weather<br><span class="text-warning" >Live </span><i class="text-warning fas fa-satellite-dish"></i></h1>
                        <form method="post" class="mb-5 w-75">
                            <input type="text" class="form-control d-table m-auto" name="city" placeholder="City name : eg. Mumbai"><br>
                            <input type="submit" href="#t-top" class="btn btn-info  btn-lg" value="Get the Current Weather Status">
                        </form>
                    </div>
                </div>  

    <div class="col-md-6">
        <?php 
            if ($api_array['cod'] == '200'){
        ?>
        <table class="table my-5 my-md-0 text-light">
            <thead id="t-top">
                <tr>
                <th scope="col"><i class="fas fa-map-marker-alt"></i></th>
                <th scope="col"><span class="text-success h2 font-weight-bold"> <?php echo $city;?></span></th>
                <th scope="col"><span class="text-warning h3"><?php echo $country; ?> </span> <span class="flag-icon flag-icon-<?php echo $flag_icon; ?>"></span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row"><i class="fas fa-cloud-moon-rain"></i></th>
                <td>Current Weather</td>
                <td><?php echo $weather;?></td>
                </tr>
                <tr>
                <th scope="row"><i class="fas fa-temperature-high"></i></th>
                <td>Temprature</td>
                <td><?php echo $temp.'&deg; C';?></td>
                </tr>
                <tr>
                <th scope="row"><i class="fas fa-tint"></i></th>
                <td>Humidity</td>
                <td><?php echo $humidity.' %';?></td>
                </tr>
                <tr>
                <th scope="row"><i class="fas fa-cloud-rain"></i></th>
                <td>Cloudiness</td>
                <td><?php echo $clouds.' %';?></td>
                </tr>
                <tr>
                <th scope="row"><i class="fas fa-wind"></i></th>
                <td>Wind Speed</td>
                <td><?php echo $wind_speed.' m/s';?></td>
                </tr>
                <tr>
                <th scope="row"><i class="far fa-clock"></i></th>
                <td>Update Time</td>
                <td><?php echo $update_time; ?></td>
                </tr>
            </tbody>
    </table>
    <?php } else {
        echo $error;
    }?>
                </div>          
            </div>
            
        </div>

    <footer class="footer fixed-bottom bg-light" style="height: 4vh">
      <div class="container">
      <small class="text-muted mt-5">Copyright &copy; 2019 | <a class="text-dark" href="https://yashwantlodhi.com/">Yashwant Lodhi</a></small>
      </div>
    </footer>
            

        
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
                function scroll() {
                    document.getElementById( 't-top' ).scrollIntoView();   
                     
                };
                scroll();
                
    
    </script>
  </body>
</html>
