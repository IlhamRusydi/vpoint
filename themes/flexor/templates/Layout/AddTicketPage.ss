<script src="$ThemeDir/lib/ckeditor/ckeditor.js"></script>
<div class="showcase block block-border-bottom-grey">
  <div class="container">
	<h2 class="block-title">
	  $Title
	</h2>
	$AddForm
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
  CKEDITOR.replace('BootstrapForm_AddForm_Content', config);
  $('#BootstrapForm_AddForm_DivisionID').change(function () {
	var id = $(this).val();
	$.ajax({
	  url: '{$Link}ajax_getcategory',
	  data: {id: id},
	  dataType: 'json',
	  type: 'post',
	  success: function (data) {
		var dropdown = '<option value="">- Pilih Kategori -</option>';
		$.each(data, function (index, item) {
		  dropdown += "<option value=" + item.ID + ">" + item.Title + "</option>";
		});
		$('#BootstrapForm_AddForm_CategoryID').html(dropdown);
	  }
	});
  });

</script>