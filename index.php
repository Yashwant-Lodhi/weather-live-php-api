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
    

    if (isset($_POST['city']) && $_POST['city'] != '') {

    $city = ucwords($_POST['city']);
    $api = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=8438ec758fdb93bcf1ec7b31a533c65c');
    $api_array = json_decode($api, true);
    $weather = $api_array['weather'][0]['description'];

    $temp = $api_array['main']['temp'] - (273.15);

    $humidity = $api_array['main']['humidity'];
    $clouds = $api_array['clouds']['all'];
    $wind_speed = $api_array['wind']['speed'];

    $update_time = $api_array['dt'];
    $update_time = gmdate('d-m-y h:i T', $update_time);

    $country = $api_array['sys']['country'];
    $flag_icon = strtolower($api_array['sys']['country']);
    
    
}
else {
    $city = '<span class="text-warning">No City Selected</span>';
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Live Weather Status</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
    <style>
    
            
            body {
            background: linear-gradient(to bottom right, rgba(0,0,0,.6), rgba(0,0,0,.9)), url(bg.png);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            scroll-behavior: smooth;
        }

    
    </style>

  </head>
  <body>
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height: 100vh;">
                <div class="col-md-6 justify-content-center align-items-center mt-5" style="height: 100vh;">
                        <h1 class="text-light display-3 my-5 font-weight-bold">Weather <span class="text-warning">LIVE</span></h1>
                        <form method="post" class="mb-5 w-75">
                            <input type="text" class="form-control d-table m-auto" name="city" placeholder="CIty name : eg. Mumbai"><br>
                            <input type="submit" href="#t-top" class="btn btn-warning  btn-lg" value="Get the Current Weather Status">
                        </form>
                </div>  

    <div class="col-md-6">
        <table class="table text-light my-5 p-5 <?php if ($_POST['city']){
            echo 'd-table';
            }else {
                echo 'd-none';
            } ?>">
    <thead id="t-top">
        <tr>
        <th scope="col">#</th>
        <th scope="col"><span class="text-success h2 font-weight-bold"> <?php echo $city;?></span></th>
        <th scope="col"><span class="text-warning h3"><?php echo $country; ?> </span> <span class="flag-icon flag-icon-<?php echo $flag_icon; ?>"></span></th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td>Current Weather</td>
        <td><?php echo $weather;?></td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td>Temprature</td>
        <td><?php echo $temp.'&deg; C';?></td>
        </tr>
        <tr>
        <th scope="row">3</th>
        <td>Humidity</td>
        <td><?php echo $humidity.' %';?></td>
        </tr>
        <tr>
        <th scope="row">4</th>
        <td>Cloudiness</td>
        <td><?php echo $clouds.' %';?></td>
        </tr>
        <tr>
        <th scope="row">5</th>
        <td>Wind Speed</td>
        <td><?php echo $wind_speed.' m/s';?></td>
        </tr>
        <tr>
        <th scope="row">6</th>
        <td>Update Time</td>
        <td><?php echo $update_time; ?></td>
        </tr>
    </tbody>
    </table>

                </div>          
            </div>
            
        </div>

    <footer class="footer fixed-bottom bg-light">
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
