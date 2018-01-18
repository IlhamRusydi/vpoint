<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<h2 class="block-title">
	  $Data.Title
	</h2>
	<ul class="list-inline meta text-muted">
	  <li><i class="fa fa-calendar"></i> <span class="visible-md"></span> $Data.Created.Format('l, d F Y')</li>
	  <li><i class="fa fa-user"></i> $Data.Member.FirstName</li>
	</ul>
	$Data.Content
	<% if $Data.Files %>
	<h3>Dokumen :</h3> 
	<hr>
	<ul>
	  <% loop $Data.Files %>
	  <li><a href="$Filename">$Name</a></li>
	  <% end_loop %>
	</ul>
	<% end_if %>
  </div>
</div>