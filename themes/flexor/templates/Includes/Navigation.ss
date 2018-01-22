<div class="container">
  <div class="navbar navbar-default">
	<!--mobile collapse menu button-->
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
	<!--social media icons-->
	<div class="navbar-text social-media social-media-inline pull-right">
	  <!--@todo: replace with company social media details-->
	  <% loop $getSocialData %>
	  <a href="$URL"><i class="$FaIcon"></i></a>
	  <% end_loop %>
	</div>
	<!--everything within this div is collapsed on mobile-->
	<div class="navbar-collapse collapse">
	  <ul class="nav navbar-nav" id="main-menu">
		<li class="icon-link"><a href="$BaseURL"><i class="fa fa-home"></i></a></li>
		<li><a href="{$getOneAboutPage.Link}">Tentang Kami</a></li>
		<li><a href="{$getOneFAQPage.Link}">FAQ</a></li>
		<li class="dropdown">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Produk<b class="caret"></b></a>
		  <!-- Dropdown Menu -->
		  <ul class="dropdown-menu">
			<li class="dropdown-header">Daftar Produk</li>
			<% loop $getProductData %>
			<li><a href="$ViewLink" tabindex="-1" class="menu-item">$Title</a></li>
			<% end_loop %>
			<li class="dropdown-footer">Daftar Produk</li>
		  </ul>
		</li>
		<li><a href="{$getOneBlogPage.Link}">Blog</a></li>
		<li><a href="{$getOneKnowledgeBasePage.Link}">Knowledge Base</a></li>
		<% if $getUserLogged %>
		<li><a href="{$getOneTicketPage.Link}">Ticket</a></li>
		<% end_if %>
		<li><a href="{$getOneContactPage.Link}">Kontak Kami</a></li>
	  </ul>
	</div>
	<!--/.navbar-collapse -->
  </div>
</div>