<!DOCTYPE html>
<html lang="en">

  <head>
	<% base_tag %>
	<title>$SiteConfig.Title &raquo; <% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)

	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="$ThemeDir/img/icons/favicon.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="$ThemeDir/img/icons/114x114.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="$ThemeDir/img/icons/72x72.png">
	<link rel="apple-touch-icon-precomposed" href="$ThemeDir/img/icons/default.png">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900" rel="stylesheet">

	<!-- Bootstrap CSS File -->
	<link href="$ThemeDir/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Libraries CSS Files -->
	<link href="$ThemeDir/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="$ThemeDir/lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">
	<link href="$ThemeDir/lib/owlcarousel/owl.theme.min.css" rel="stylesheet">
	<link href="$ThemeDir/lib/owlcarousel/owl.transitions.min.css" rel="stylesheet">

	<!-- Main Stylesheet File -->
	<link href="$ThemeDir/css/style.css" rel="stylesheet">
	<script src="$ThemeDir/lib/jquery/jquery.min.js"></script>

	<!--Your custom colour override - predefined colours are: colour-blue.css, colour-green.css, colour-lavander.css, orange is default-->

	<!-- =======================================================
	  Theme Name: Flexor
	  Theme URL: https://bootstrapmade.com/flexor-free-multipurpose-bootstrap-template/
	  Author: BootstrapMade.com
	  Author URL: https://bootstrapmade.com
	======================================================= -->
  </head>

  <body class="page-index has-hero">
	<!--Change the background class to alter background image, options are: benches, boots, buildings, city, metro -->
	<div id="background-wrapper" class="buildings" data-stellar-background-ratio="0.1">

	  <!-- ======== @Region: #navigation ======== -->
	  <div id="navigation" class="wrapper">
		<!--Header & navbar-branding region-->
		<div class="header">
		  <div class="header-inner container">
			<div class="row">
			  <div class="col-md-8">
				<!--navbar-branding/logo - hidden image tag & site name so things like Facebook to pick up, actual logo set via CSS for flexibility -->
				<a class="navbar-brand" style="" href="index.html" title="Home">
				  <img src="$SiteConfig.Logo.CroppedImage(50,50).Filename" alt="$SiteConfig.Title">
				</a>
				<div class="navbar-slogan">
				  <b style="font-size: 27px;font-family: sans-serif;">$SiteConfig.Title</b>
				  <br> $SiteConfig.Tagline
				</div>
			  </div>
			  <!--header rightside-->
			  <div class="col-md-4">
				<!--user menu-->
				<ul class="list-inline user-menu pull-right">
				  <% if $getUserLogged %>
				  <li class="user-login">Selamat Datang, (<a href="{$getOneMemberPage.Link}profil" class="text-uppercase">$getUserLogged.FirstName</a>)</li>
				  <li class="user-login"><i class="fa fa-sign-out text-primary"></i> <a href="Security/logout" class="text-uppercase">Logout</a></li>
				  <% else %>
				  <li class="user-login"><i class="fa fa-sign-in text-primary"></i> <a href="Security/login" class="text-uppercase">Login</a></li>
				  <% end_if %>

				</ul>
			  </div>
			</div>
		  </div>
		</div>
		<% include Navigation %>
	  </div>
	  <% include SliderImage %>
	</div>

	<!-- ======== @Region: #content ======== -->
	<div id="content">
	  $Layout
	</div>
	<!-- /content -->
	<!-- Call out block -->
	<div class="block block-pd-sm block-bg-primary">
	  <div class="container">
		<div class="row">
		  <h3 class="col-md-3">
            Klien Kami
          </h3>
		  <div class="col-md-9">
			<div class="row">
			  <!--Client logos should be within a 120px wide by 60px height image canvas-->
			  <% loop $getClientData %>
			  <div class="col-xs-6 col-md-2">
				<a href="http://$Website" title="$Title">
                  <img src="$Photo.CroppedImage(120,60).Filename" alt="$Title" class="img-responsive">
                </a>
			  </div>
			  <% end_loop %>
			</div>
		  </div>
		</div>
	  </div>
	</div>

	<!-- ======== @Region: #footer ======== -->
	<footer id="footer" class="block block-bg-grey-dark" data-block-bg-img="$ThemeDir/img/bg_footer-map.png" data-stellar-background-ratio="0.4">
	  <div class="container">

		<div class="row" id="contact">

		  <div class="col-md-3">
			<h4 class="text-uppercase">
			  KONTAK KAMI
			</h4>
			<div class="row">
			  <div class="col-md-1"><i class="fa fa-map-pin fa-fw text-primary"></i></div><div class="col-md-10">$SiteConfig.Address</div>
			  <div class="col-md-1"><i class="fa fa-phone fa-fw text-primary"></i></div><div class="col-md-10">$SiteConfig.Phone</div>
			  <div class="col-md-1"><i class="fa fa-envelope-o fa-fw text-primary"></i></div><div class="col-md-10">$SiteConfig.EmailContact</div>
			</div>
		  </div>

		  <div class="col-md-3">
			<h4 class="text-uppercase">
              PETA SITUS
            </h4>
			<div><a href="$URL">Home</a></div>
			<div><a href="$URL">Tentang Kami</a></div>
			<div><a href="$URL">F.A.Q</a></div>
			<div><a href="$URL">Produk</a></div>
			<div><a href="$URL">Dukungan</a></div>
			<div><a href="$URL">Blog</a></div>
			<div><a href="$URL">Kontak Kami</a></div>
		  </div>

		  <div class="col-md-3">
			<h4 class="text-uppercase">
              PRODUK
            </h4>
			<% loop $getProductData %>
			<div><a href="$ViewLink">$Title</a></div>
			<% end_loop %>
		  </div>

		  <div class="col-md-3">
			<h4 class="text-uppercase">
              MEDIA SOSIAL
            </h4>
			<!--social media icons-->
			<div class="social-media social-media-stacked">
			  <% loop $getSocialData %>
			  <a href="http://$URL"><i class="fa $FaIcon fa-fw"></i> $Title</a>
			  <% end_loop %>
			</div>
		  </div>
		</div>

		<div class="row subfooter">
		  <!--@todo: replace with company copyright details-->
		  <div class="col-md-7">
			<p>Copyright © $SiteConfig.Title</p>
			<div class="credits">
			  <a href="https://bootstrapmade.com/">Free Bootstrap Templates</a> by BootstrapMade.com
			</div>
		  </div>
		  <div class="col-md-5">
			<ul class="list-inline pull-right">
			  <li><a href="#">Terms</a></li>
			  <li><a href="#">Privacy</a></li>
			  <li><a href="#">Contact Us</a></li>
			</ul>
		  </div>
		</div>

		<a href="#top" class="scrolltop">Top</a>

	  </div>
	</footer>

	$SiteConfig.ChatScript.RAW
	$SiteConfig.GoogleAnalyticsScript.RAW

	<!-- Required JavaScript Libraries -->
	<script src="$ThemeDir/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="$ThemeDir/lib/owlcarousel/owl.carousel.min.js"></script>
	<script src="$ThemeDir/lib/stellar/stellar.min.js"></script>
	<script src="$ThemeDir/lib/waypoints/waypoints.min.js"></script>
	<script src="$ThemeDir/lib/counterup/counterup.min.js"></script>
	<script src="$ThemeDir/contactform/contactform.js"></script>

	<!-- Template Specisifc Custom Javascript File -->
	<script src="$ThemeDir/js/custom.js"></script>

	<!--Custom scripts demo background & colour switcher - OPTIONAL -->
	<script src="$ThemeDir/js/color-switcher.js"></script>

	<!--Contactform script -->
	<script src="$ThemeDir/contactform/contactform.js"></script>

  </body>

</html>
