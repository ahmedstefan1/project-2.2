<!DOCTYPE html>
<html lang="en">

	<?php
	// You'd put this code at the top of any "protected" page you create
	// Always start this first
	session_start();

	if(isset($_SESSION['user_id'])) {
		// Grab user data from the database using the user
		// Let them access the "logged in only" pages
	} else {
		// Redirect them to the login page
		header("Location: index.php");
	}
	?>

    <head>

        <meta charset="utf-8">
        <title>Shasky - Weather Application</title>

        <meta name="keywords" content="pistaciatheme, pistacia theme, food blog, chef, cook, cooking, eat, food, meals, recipe theme, recipes theme, html5 theme, clean theme, fresh theme">
        <meta name="author" content="bumbella">

        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Stylesheets -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="assets/css/font-awesome.css" />
        <link rel="stylesheet" href="assets/css/socicons.css" />
        <link rel="stylesheet" href="assets/css/hover.css" />
        <link rel="stylesheet" href="assets/css/animate.css" />
        <link rel="stylesheet" href="assets/css/style.css" />

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Merriweather:400,700,400italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,700,800,900' rel='stylesheet' type='text/css'>

        <!-- Favicons -->
        <link rel="shortcut icon" href="assets/img/ico/favicon.ico" type="image/x-icon"/>
        <link rel="apple-touch-icon" sizes="57x57" href="assets/img/ico/apple-touch-icon-57x57.png"/>
        <link rel="apple-touch-icon" sizes="72x72" href="assets/img/ico/apple-touch-icon-72x72.png"/>
        <link rel="apple-touch-icon" sizes="114x114" href="assets/img/ico/apple-touch-icon-114x114.png"/>
        <link rel="apple-touch-icon" sizes="144x144" href="assets/img/ico/apple-touch-icon-144x144.png"/>

    </head>
    <body id="pageTop">

        <!-- ***** Page loader ***** -->
        <div class="page-loader">
            <div class="loading">
                <div class="loading-spin"></div>
                <span>Loading...</span>
            </div>
        </div><!-- /.page-loader -->

        <!-- ***** Top Navigation ***** -->
        <section id="topNavigation" class="top-navigation">

            <nav class="navbar navbar-default" role="navigation">

                <div class="container container-inner">

                    <div class="navbar-header">

                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-menu-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="btn-cart-xs visible-xs" href="#"><i class="fa fa-shopping-cart primary-color"></i><span>3</span></a>

                        <a class="navbar-brand"><img src="assets/img/logo/logo.png" class="img-responsive" alt="Pistacia Restaurant And Food Template"></a>

                    </div>

                    <div class="collapse navbar-collapse" id="top-menu-collapse">

                        <ul id="top-menu" class="nav navbar-nav navbar-left">
                            <li>
								<a href="stations.php">Stations</a>
							</li>
							<li class="active">
                                <a href="data.php">Data</a>
                            </li>
							<li>
								<a href="downloads.php">Downloads</a>
							</li>
                        </ul><!-- /#top-menu -->

                        <ul id="topIcons" class="nav navbar-nav navbar-right hidden-xs">
							<li>
								<a href="index.php">Logout</a>
							</li>
                        </ul><!-- /#topIcons -->

                    </div><!-- /.top-menu-collapse -->

                </div>

            </nav>

        </section><!-- /.top-navigation -->


        <!-- ***** Header ***** -->
        <header class="header portfolio-header">

            <div class="header-img">
                <div class="overlay overlay-black-70"></div>
            </div>

        </header>


        <!-- ***** Breadcrumb ***** -->
        <div class="container-fluid breadcrumb-container">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">Data</a></li>
                </ol>
            </div>
        </div>


				<section class="loc-wrapper" id="locWrapper">
						<div class="container">
							<h1>Temperature</h1>
							<h2>Coldest places Oman</h2>
				<table class="table table-hover table-data" id="myTable">
					<thead class="table-head">
						<tr>
							<th onclick="sortTable(0)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>Station</th>
							<th onclick="sortTable(1)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>Date</th>
							<th onclick="sortTable(2)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>Time</th>
							<th onclick="sortTable(3)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>Temperature</th>
						</tr>
					</thead>
					<tbody class="table-body">
						<?php


						$dbhost = "localhost";
						$dbuser = "root";
						$dbpass = "";
						$dbname = "home_server";

						// Start a connection with the database
						$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


						$stationsOman = array("405750", "412410", "412460","412540","412560","412880","413140","413160");


						$mostrecent=array();
						$folder = scandir("./xml/");
						unset($folder[1]);
						unset($folder[0]);
						foreach ($folder as $folder_name) {
							if (in_array($folder_name,$stationsOman)){
							if ($handle1 = opendir('./xml/'.$folder_name)) {
								$files = scandir("./xml/$folder_name");
								unset($files[1]);
								unset($files[0]);
								array_push($mostrecent, ("./xml/$folder_name/".end($files)));
								foreach ($files as $key) {
									$fpath = './xml/'.$folder_name."/".$key;
									if (file_exists($fpath)) {
										$filelastmodified = filemtime($fpath);
								}
								}
						}
						}
						}

						$fileList = $mostrecent;

						$toplisttemp = array();

						//Loop through the array that glob returned.
						foreach($fileList as $filename){
							$nested_array = array();
							 $xml=simplexml_load_file("$filename") or die("Error: Cannot create object");
							 $station = $xml->measurment[0]->stn;
							 $sql = "SELECT * FROM `stations` WHERE `stn` = '$station'";
							 $result = $con->query($sql);
							 if ($result->num_rows > 0) {
									 // output data of each row
									 while($row = $result->fetch_assoc()) {
											 $name = $row["name"];
									 }
								 }
							 $date = $xml->measurment[0]->Date;
							 $time = $xml->measurment[0]->time;
							 $temp = $xml->measurment[0]->temp;

							 $nested_array[0]=$name;
							 $nested_array[1]=$date;
							 $nested_array[2]=$time;
							 $nested_array['temp']=$temp;

						array_push($toplisttemp, $nested_array);

						}

						function val_sort($array,$key) {

						//Loop through and get the values of our specified key
						foreach($array as $k=>$v) {
							$b[] = strtolower($v[$key]);
						}

						asort($b);

						foreach($b as $k=>$v) {
							$c[] = $array[$k];
						}

						return $c;
						}

						$sorted = val_sort($toplisttemp, 'temp');


						foreach ($sorted as $key) {
							echo "<tr>";
							foreach($key as $value){
								echo "<td>".$value."</td>";
							}
							echo "</tr>";
						}

						?>
					</tbody>
				</table>

				</div><!-- /.container -->

				</section>

				<section class="loc-wrapper" id="locWrapper">
						<div class="container">
							<h1>Wind</h1>
							<h2>Top windspeeds in Oman</h2>
				<table class="table table-hover table-data" id="myTable">
					<thead class="table-head">
						<tr>
							<th onclick="sortTable(0)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>Station</th>
							<th onclick="sortTable(1)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>Date</th>
							<th onclick="sortTable(2)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>Time</th>
							<th onclick="sortTable(3)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>windspeed</th>
							<th onclick="sortTable(3)"><img src="assets\img\content\sort.png" style="width:20px;height:20px;"/>wind direction</th>
						</tr>
					</thead>
					<tbody class="table-body">
						<?php


						$dbhost = "localhost";
						$dbuser = "root";
						$dbpass = "";
						$dbname = "home_server";

						// Start a connection with the database
						$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


						$fileList = $mostrecent;

						$toplisttemp = array();

						//Loop through the array that glob returned.
						foreach($fileList as $filename){
							$nested_array = array();
							 $xml=simplexml_load_file("$filename") or die("Error: Cannot create object");
							 $station = $xml->measurment[0]->stn;
							 $sql = "SELECT * FROM `stations` WHERE `stn` = '$station'";
							 $result = $con->query($sql);
							 if ($result->num_rows > 0) {
									 // output data of each row
									 while($row = $result->fetch_assoc()) {
											 $name = $row["name"];
									 }
								 }
							 $date = $xml->measurment[0]->Date;
							 $time = $xml->measurment[0]->time;
							 $wndsp = $xml->measurment[0]->wdsp;
							 $wnddir = $xml->measurment[0]->wnddir;

							 $nested_array[0]=$name;
							 $nested_array[1]=$date;
							 $nested_array[2]=$time;
							 $nested_array['wndsp']=$wndsp;
							 $nested_array[4]=$wnddir;

						array_push($toplisttemp, $nested_array);

						}


						$sorted = array_reverse(val_sort($toplisttemp, 'wndsp'));


						foreach ($sorted as $key) {
							echo "<tr>";
							foreach($key as $value){
								echo "<td>".$value."</td>";
							}
							echo "</tr>";
						}

						?>
					</tbody>
				</table>

				</div><!-- /.container -->

				</section>


        <!-- ***** Footer ***** -->
        <footer id="footer" class="footer">

            <div class="overlay overlay-black-80"></div>

            <div class="container container-inner">

                <div class="row">

                    <div class="col-md-3">

                        <h2><span class="extra-bold">Contact</span> <span class="light">Us</span></h2>

                        <ul class="contacts">
                            <li><i class="fa fa-map-marker"></i>Rusayl Industrial Area, Muscat</li>
                            <li><i class="fa fa-phone"></i>2444 9166</li>
                            <li><i class="fa fa-envelope"></i><a href="#">info@shaksygroup.com</a></li>
                        </ul>

                    </div><!-- /.col-md-3 -->

                    <div class="col-md-3 about-us">

                        <h2><span class="extra-bold">About</span> <span class="light">Shaksy</span></h2>

                        <div class="">
                           Core to our success are the contributions of our diverse team of experts, each with years of experiences in the respective fields.
                        </div>

                    </div><!-- /.about-us -->

                </div><!-- /.row -->

            </div><!-- /.container-inner -->

        </footer>


        <!-- ***** Bottom bar ***** -->
        <section class="bottom-bar" id="bottomBar">

            <a onclick="topFunction()" class="btn btn-white scroll-to"><i class="fa fa-chevron-up"></i></a>

            <div class="container">

                <div class="pull-left">
                    <div class="padding-top-20"><span class="small">Design by Bumbella - Te discere erroribus sed.</span></div>
                </div>

                <div class="pull-right">
                    <ul class="clear bottom-menu">

                    </ul>
                </div>

            </div><!-- /.container -->

        </section><!-- /.bottom-bar -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->

        <!-- Scripts -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.js"></script>
        <script src="assets/js/smoothscroll.js"></script>
        <script src="assets/js/html5shiv.js"></script>
        <script src="assets/js/scrollto.js"></script>
        <script src="assets/js/imagesloaded.js"></script>
        <script src="assets/js/parallax.js"></script>
        <script src="assets/js/easing.js"></script>
        <script src="assets/js/masonry.js"></script>
		<script src="assets/js/scrolltop.js"></script>

        <!-- Application -->
        <script src="assets/js/application.js"></script>

        <!-- Scripts only this page -->
        <script type="text/javascript">
            APP.init();
            APP.stickynav();
            APP.parallax();
            APP.portfolio();
        </script>

    </body>
</html>
