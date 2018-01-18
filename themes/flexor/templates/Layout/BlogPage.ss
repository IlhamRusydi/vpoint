<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<% if $ListData %>
	<div class="row">
	  <!--Latest Blog posts-->
	  <div class="col-md-9 blog-roll">
		<h2 class="block-title" style="margin-bottom: 35px;">
		  $Title
		</h2>
		<div class="blog-roll">
		  <% loop $ListData %>
		  <div class="media">
			<div class="media-body">
			  <h4 class="media-heading">
				<a href="$ViewLink" class="text-weight-strong">$Title</a>
			  </h4>
			  <!-- Meta details mobile -->
			  <ul class="list-inline meta text-muted">
				<li><i class="fa fa-calendar"></i> <span class="visible-md"></span> $Created.Format('l, d F Y')</li>
				<li><i class="fa fa-user"></i> $Member.FirstName</li>
			  </ul>
			  $Content.LimitCharacters(300)
			</div>
		  </div>
		  <% end_loop %>
		</div>
	  </div>
	  <div class="col-md-3">
		<div class="row">
		  <form action="" method="get">
			<div class="form-group col-md-12">
			  <div class="input-group">
				<input type="text" class="form-control" placeholder="Search" name="Search">
				<div class="input-group-btn">
				  <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
				</div>
			  </div>
			</div>
			<div class="form-group col-md-12">
			  <select name="Category" class="form-control">
				<option value="">- Pilih Kategori -</option>
				<% loop $getBlogCategoryData %>
				<option value="$URLSegment">$Title</option>
				<% end_loop %>
			  </select>
			</div>
		  </form>
		</div>
	  </div>
	  <div class="text-center pagination">
		$Pagination
	  </div>
	</div>
	<% else %>
	<div class="row" style="padding-bottom: 15px;">
	  <div class="col-md-12">
		<h3 class="block-title">Maaf, Data tidak ditemukan</h3>
	  </div>
	</div>
	<% end_if %>
  </div>
</div>