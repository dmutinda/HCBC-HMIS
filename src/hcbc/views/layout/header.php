<?php $valid = $this->auth->isValid();?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    	<meta name="description" content="<?php echo $this->app->getAppCompany();?> Home based health care.">
    	<meta name="keywords" content="<?php echo $this->app->getAppCompany();?> community, health, care, HMIS, EMR">
		<meta name="author" content="Daniel Mutinda">
		<title>HCBC | <?php echo $this->app->getAppCompany();?></title>
		<link rel='shortcut icon' type='image/x-icon' href='/public/img/icons/favicon.ico' />
		<link href="/public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/public/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
		<link href="/public/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="/public/css/typeahead.css" rel="stylesheet" type="text/css" />
		<link href="/public/css/fonts/font-awesome.css" rel="stylesheet" type="text/css" />
		<link href="/public/css/app/app.css" rel="stylesheet" type="text/css" />
	</head>
	<body>

	<div class="header-top">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">
						<?php echo $this->app->getAppCompany();?>
					</a>
				</div>
				
				<!-- login -->
				<?php if($valid):?>
					<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Profile <i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">Change Password</a></li>
								<li class="divider"></li>
								<li><a href="#">User Account</a></li>
								<li class="divider"></li>
								<li><a href="#">Contact Support</a></li>
								<li><a href="#">Send us your Feedback</a></li>
								<li class="divider"></li>
								<li><a href="#">Sign Out</a></li>
							</ul>
						</li>
					</ul>
				<?php else:?>
					<div class="navbar-btn-wrapper">
						<div class="navbar-right">
							<a class="btn btn-default navbar-btn" href="#">WORK WITH US!</a>
							<a class="btn btn-green navbar-btn" href="#">SIGN IN</a>
						</div>
					</div>
				<?php endif;?>

			</div>
		</nav>
	</div>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid"> 
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li ><a href="/">Home</a></li>
					<li><a href="#">Institution</a></li>
					<li><a href="#">Facilities</a><li> 
					<li><a href="#">Forms</a></li> 
					<li><a href="#">Reports</a></li>
				</ul>
				<!-- authenticated menus -->
			</div>
		</div>
	</nav>

	<div id="content" class="container main-content">	