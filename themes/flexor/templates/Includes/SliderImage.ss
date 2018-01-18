<% if $getSliderImageData %>
<div class="hero" id="highlighted">
  <div class="inner">
	<!--Slideshow-->
	<div id="highlighted-slider" class="container">
	  <div class="item-slider" data-toggle="owlcarousel" data-owlcarousel-settings='{"singleItem":true, "navigation":true, "transitionStyle":"fadeUp"}'>
		<!--Slideshow content-->
		<% loop $getSliderImageData %>
		<div class="item">
		  <div class="row">
			<div class="col-md-6 col-md-push-6 item-caption">
			  <h2 class="h1 text-weight-light">
				<span class="text-primary">$Title</span>
			  </h2>
			  <h4>
				$Description
			  </h4>
			  $Content
			</div>
			<div class="col-md-6 col-md-pull-6 hidden-xs">
			  <img src="$Photo.Filename" alt="$Title" class="center-block img-responsive">
			</div>
		  </div>
		</div>
		<% end_loop %>
	  </div>
	</div>
  </div>
</div>
<% end_if %>