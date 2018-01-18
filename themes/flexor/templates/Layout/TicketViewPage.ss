<script src="$ThemeDir/lib/ckeditor/ckeditor.js"></script>
<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<h3 class="block-title">
	  $Data.Number - $Data.Title
	</h3>
	<small class="text-muted">$Data.LastEdited.Nice</small> <span class="<% if $Data.Read %>fa fa-check<% else %>fa fa-clock-o<% end_if %>"></span><br>
	$Data.getStatusLabel <% if $Data.CanClose %><a href="$Data.CloseLink" title="Close Ticket" class="label label-success">Close Ticket</a><% end_if %> 
	<p>$Data.Content</p>
	<hr>
	<% if $Data.Responses %>
	<% loop $Data.Responses %>
	<div>
	  <div><b>$Member.FirstName</b> <small class="text-muted">$Created.Nice</small></div>
	  <p>
		$Content
	  </p>
	</div>
	<hr>
	<% end_loop %>
	<% end_if %>
	<% if $Data.CanComment %>
	<div>
	  $CommentForm($Data.ID)
	</div>
	<% end_if %>
  </div>
</div>
<script>
  var uploadUrl = '{$Link}uploadimages';
  var config = {
	filebrowserUploadUrl: uploadUrl + '?Type=File',
	filebrowserImageUploadUrl: uploadUrl + '?Type=Image',
	extraPlugins: 'uploadimage',
	allowedContent: true
  };
  CKEDITOR.replace('BootstrapForm_CommentForm_Content', config);
</script>