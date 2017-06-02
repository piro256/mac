<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="hardware mac vendor">
    <meta name="author" content="piro256">
    <link rel="shortcut icon" href="../ico/favicon.ico">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>mac address lookup</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container col-md-4 col-md-offset-4">

      <form class="form-signin" action="index.php" method="GET">
          <h2 class="form-signin-heading"> <img src="lable.png" width="30px"> Whose address is this?</h2>
        <div class="input-group">
          <input type="text" class="form-control" placeholder="MAC-address" name="serch_mac">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit">Serch</button>
          </span>
        </div>
      </form>
        <br>
    <?php
    include './config.php';

    $serch_mac = filter_input(INPUT_GET, 'serch_mac', FILTER_SANITIZE_SPECIAL_CHARS);
    if ($serch_mac != "")
        {
        //убираем пробелы до и после
        $serch_mac = trim($serch_mac);
        //удаляем разделители и всё лишнее 
        //что могло к нам придти из GET
        $vowels = ["-", ":", ".", ",", "'", "\\", "\s", "\r", "\n", "\t"];
        $serch_mac = str_replace($vowels, "", $serch_mac);

        $mac = substr($serch_mac, 0, 6);

        echo "<p><b>Результат:</b></p>";
        $mac_query = mysqli_query($link_to_mysql, "SELECT * FROM mac WHERE mac LIKE '$mac'") or die("SELECT mac R.I.P.");
        for ($mac_query_count = 0; $mac_query_count < mysqli_num_rows($mac_query); $mac_query_count++)
        {
            $mac_result = mysqli_fetch_assoc($mac_query);
            echo "<p><h4>" . $mac_result[mac] . " - ";
            echo $mac_result[vendor] . " - ";
            echo $mac_result[country];

            //запрашиваем флаги
            $country_query = mysqli_query($link_to_mysql, "SELECT * FROM countries WHERE alpha2 LIKE '$mac_result[country]'") or die("Select COUNTRY R.I.P.");
            for ($country_query_count = 0; $country_query_count < mysqli_num_rows($country_query); $country_query_count++)
            {
                $country_result = mysqli_fetch_assoc($country_query);
                echo " <img src=\"flags/48px/". $country_result[flag] ."\" width=\"24\">";
                echo "</h4></p>";
            }
        }
        echo "<p><b>Остальные адреса вендора:</b></p>";

        //запрашиваем остальные префиксы закрепленные за компанией
        $query_result = mysqli_query($link_to_mysql, "SELECT * FROM mac WHERE vendor LIKE '$mac_result[vendor]'");
        for ($count = 0; $count < mysqli_num_rows($query_result); $count++)
        {
            $mac_result = mysqli_fetch_assoc($query_result);
            echo $mac_result[mac] . " ";  
        }
    }
    ?>
    </div> <!-- /container -->
    <div class="navbar-fixed-bottom row-fluid container col-md-2 col-md-offset-10">
      <div class="navbar-inner">
          <div class="container"> 
              <p> &#169; piro256</p>
          </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed 
    <script src="js/bootstrap.min.js"></script>-->
  </body>
</html>