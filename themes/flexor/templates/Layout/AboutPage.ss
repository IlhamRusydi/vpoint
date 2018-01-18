<div class="container" id="about">
  <div class="row">
	<!--main content-->
	<div class="col-md-9 col-md-push-3">
	  <div class="page-header">
		<h1>
		  $Title
		</h1>
	  </div>
	  <div class="block block-border-bottom-grey block-pd-sm">
		<h3 class="block-title">
		  <% if $Data %>
		  $Data.SubTitle
		  <% else %>
		  $SubTitle
		  <% end_if %>
		</h3>
		<% if $Data %>
		$Data.Content
		<% else %>
		$Content
		<% end_if %>
	  </div>
	</div>
	<!-- sidebar -->
	<div class="col-md-3 col-md-pull-9 sidebar visible-md-block visible-lg-block">
	  <ul class="nav nav-pills nav-stacked">
		<% loop $getAboutData %>
		<li class="<% if $Top.Data.ID == $ID %>active<% end_if %>">
		  <a href="$ViewLink" class="first">
			$Title
			<small>$SubTitle</small>
		  </a>
		</li>
		<% end_loop %>
	  </ul>
	</div>
  </div>
</div>