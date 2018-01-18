<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<h2 class="block-title">
	  $Title
	</h2>
	<% loop $ListData %>
	<p><span class="fa fa-question-circle-o"></span> <a href="#" data-toggle="collapse" data-target="#faq-$ID">$Title</a></p>
	<div id="faq-$ID" class="collapse">$Content</div>
	<% end_loop %>
  </div>
</div>