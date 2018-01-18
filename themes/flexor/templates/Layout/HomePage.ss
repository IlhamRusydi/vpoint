<!-- Mission Statement -->
<div class="mission text-center block block-pd-sm block-bg-noise">
  <div class="container">
	<h2 class="text-shadow-white">
	  $Description
	</h2>
  </div>
</div>
<!--Showcase-->
<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<h2 class="block-title">
	  $SiteConfig.Title
	</h2>
	$Content
  </div>
</div>
<!-- Services -->
<div class="services block block-bg-gradient block-border-bottom">
  <div class="container">
	<h2 class="block-title">
	  Produk Kami
	</h2>
	<div class="item-carousel" data-toggle="owlcarousel" data-owlcarousel-settings='{"items":4, "pagination":false, "navigation":true, "itemsScaleUp":true}'>
	  <% loop $getProductData %>
	  <div class="item">
		<a href="#" class="overlay-wrapper">
		  <img src="$Photo.CroppedImage(200,200).Filename" alt="$Title" class="img-responsive underlay">
		  <span class="overlay">
			<span class="overlay-content"> <span class="h4">$Title</span> </span>
		  </span>
		</a>
		<div class="item-details bg-noise">
		  <h4 class="item-title">
			<a href="#">$Title</a>
		  </h4>
		  <a href="$ViewLink" class="btn btn-more"><i class="fa fa-plus"></i>Detail</a>
		</div>
	  </div>
	  <% end_loop %>
	</div>
  </div>
</div>
<!--Customer testimonial & Latest Blog posts-->
<div class="testimonials block-contained">
  <div class="row">
	<!--Customer testimonial-->
	<div class="col-md-6 blog-roll">
	  <h3 class="block-title">
		Knowledge Base
	  </h3>
	  <!-- Blog post 1-->
	  <% loop $getLatestKnowledgeBaseData %>
	  <div class="media">
		<h4 class="media-heading">
		  <span class="fa fa-plus text-primary"></span> <a href="$ViewLink" class="text-weight-strong">$Title</a>
		</h4>
	  </div>
	  <% end_loop %>
	</div>
	<!--Latest Blog posts-->
	<div class="col-md-6 blog-roll">
	  <h3 class="block-title">
		Post Terbaru
	  </h3>
	  <!-- Blog post 1-->
	  <% loop $getLatestBlogData %>
	  <div class="media">
		<div class="media-left hidden-xs">
		  <!-- Date desktop -->
		  <div class="date-wrapper"> <span class="date-m">$Created.Format('M')</span> <span class="date-d">$Created.Format('d')</span> </div>
		</div>
		<div class="media-body">
		  <h4 class="media-heading">
			<a href="$ViewLink" class="text-weight-strong">$Title</a>
		  </h4>
		  <!-- Meta details mobile -->
		  <ul class="list-inline meta text-muted visible-xs">
			<li><i class="fa fa-calendar"></i> <span class="visible-md">Created:</span> $Created.Format('l d F Y')</li>
			<li><i class="fa fa-user"></i> <a href="#">$Member.FirstName</a></li>
		  </ul>
		  <p>
			$Content.LimitCharacters(200)
			<a href="$ViewLink">Read more <i class="fa fa-angle-right"></i></a>
		  </p>
		</div>
	  </div>
	  <% end_loop %>
	</div>
  </div>
</div>