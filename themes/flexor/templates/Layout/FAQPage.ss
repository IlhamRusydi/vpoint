<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<div class="row">
	  <div class="col-md-8">
		<h2 class="block-title">
		  $Title
		</h2>
	  </div>
	  <div class="col-md-4">
		<form action="" method="get">
		  <div class="form-group">
			<div class="input-group">
			  <input type="text" class="form-control" placeholder="Search" name="search" value="$Data.search">
			  <div class="input-group-btn">
				<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
			  </div>
			</div>
		  </div>
		</form>
	  </div>
	</div>
	<% if $ListData %>
	<div class="row">
	  <div class="col-md-12 blog-roll">
		<div class="blog-roll">
		  <% loop $ListData %>
		  <p><span class="fa fa-question-circle-o"></span> <a href="#" data-toggle="collapse" data-target="#faq-$ID">$Title</a></p>
		  <div id="faq-$ID" class="collapse">$Content</div>
		  <% end_loop %>
		</div>
	  </div>
	</div>
	<div class="col-md-4 col-md-offset-4">
	  $Pagination
	</div>
	<% else %>
	<div class="row" style="padding-bottom: 15px;">
	  <div class="col-md-12">
		<h3>Maaf, Data tidak ditemukan</h3>
	  </div>
	</div>
	<% end_if %>
  </div>
</div>