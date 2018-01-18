<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<h2 class="block-title">
	  $Title
	</h2>
	<p><a href="{$Link}add" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> Open Ticket</a></p>
	<div class="table-responsive">
	  <table class="table table-hover table-striped">
		<thead>
		  <tr>
			<th>Created</th>
			<th>Judul</th>
			<th>Last Modified</th>
			<th>Status</th>
		  </tr>
		</thead>
		<tbody>
		  <% if $ListData %>
		  <% loop $ListData %>
		  <tr>
			<td>$Created.Format('d/m/Y H:i')</td>
			<td><a href="$ViewLink">$Number - $Title</a></td>
			<td>$LastEdited.Format('d/m/Y H:i')</td>
			<td>$getStatusLabel</td>
		  </tr>
		  <% end_loop %>
		  <% else %>
		  <tr>
			<td colspan="4" class="text-center text-muted"><i>(No Data)</i></td>
		  </tr>
		  <% end_if %>
		</tbody>
	  </table>
	</div>
  </div>
</div>