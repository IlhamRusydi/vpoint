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
	  <!--Latest Blog posts-->
	  <% loop $ListData %>
	  <div class="col-md-6">
		<h4><a href="#" data-toggle="collapse" data-target="#kb-{$Category.ID}"><span class="fa fa-plus"></span> $Category.Title ($KnowledgeBases.count)</a></h4>
		<ul id="kb-{$Category.ID}" class="list list-dotted collapse">
		  <% loop $KnowledgeBases %>
		  <li><a href="$ViewLink"> $Title</a></li>
		  <% end_loop %>
		</ul>
	  </div>
	  <% end_loop %>
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