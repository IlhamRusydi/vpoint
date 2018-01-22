<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<div class="row">
	  <div class="col-md-8">
		<h2 class="block-title" style="margin-bottom: 35px;">
		  $Title
		</h2>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-9 blog-roll">
		<% if $ListData %>
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
			  <a href="$ViewLink">Read more <i class="fa fa-angle-right"></i></a>
			</div>
		  </div>
		  <% end_loop %>
		</div>
		<div class="col-md-6 col-md-offset-4">
		  $Pagination
		</div>
		<% else %>
		<h3>Maaf, Data tidak ditemukan</h3>
		<% end_if %>
	  </div>
	  <div class="col-md-3">
		<form action="" method="get">
		  <div class="form-group">
			<div class="input-group">
			  <input type="text" class="form-control" value="$Data.search" placeholder="Search" name="search">
			  <div class="input-group-btn">
				<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<select name="category" class="form-control">
			  <option value="">- Pilih Kategori -</option>
			  <% loop $getBlogCategoryData %>
			  <option value="$URLSegment" <% if $Top.Data.category == $URLSegment %>selected<% end_if %>>$Title</option>
			  <% end_loop %>
			</select>
		  </div>
		</form>
	  </div>
	</div>
  </div>