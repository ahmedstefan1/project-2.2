<!DOCTYPE html>
<html lang="en">

	<?php
		session_start();
		session_destroy();
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
		<link rel="stylesheet" href="assets/css/login.css" />

        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Merriweather:400,700,400italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,700,800,900' rel='stylesheet' type='text/css'>

        <!-- Favicons -->
        <link rel="shortcut icon" href="assets/img/ico/favicon.ico" type="image/x-icon"/>
        <link rel="apple-touch-icon" sizes="57x57" href="assets/img/ico/apple-touch-icon-57x57.png"/>
        <link rel="apple-touch-icon" sizes="72x72" href="assets/img/ico/apple-touch-icon-72x72.png"/>
        <link rel="apple-touch-icon" sizes="114x114" href="assets/img/ico/apple-touch-icon-114x114.png"/>
        <link rel="apple-touch-icon" sizes="144x144" href="assets/img/ico/apple-touch-icon-144x144.png"/>
		
		<?php
		include 'assets\php\loginproces.php';
		?>
		
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
                            <li class="active">
                                <a href="index.php">Login</a>
                            </li>
                        </ul><!-- /#top-menu -->

                    </div><!-- /.top-menu-collapse -->

                </div>

            </nav>

        </section><!-- /.top-navigation -->


        <!-- ***** Header ***** -->
        <header class="header">

            <div class="header-img">
                <div class="overlay overlay-black-70"></div>
                <div class="container container-inner">

                </div>
            </div>

        </header>

		<!-- ***** Breadcrumb ***** -->
        <div class="container-fluid breadcrumb-container">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="#">Login</a></li>
                </ol>
            </div>
        </div>
		
		<!-- ***** Login form ***** -->
		<div class="container">
			<div class="row vertical-offset-100">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Please sign in</h3>
						</div>
						<div class="panel-body">
							
							<form accept-charset="UTF-8" role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Username" name="username" type="text">
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="password" type="password">
								</div>
								<input class="btn btn-block" type="submit" value="Login">
							</fieldset>
							</form>
							<?php echo $return_msg; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

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
		
        <!-- Application -->
        <script src="assets/js/application.js"></script>

        <!-- Scripts only this page -->
        <script type="text/javascript">
            APP.init();
            APP.stickynav();
            APP.parallax();
        </script>

    </body>
</html>