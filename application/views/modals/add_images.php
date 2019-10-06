<form method="POST" action="<?= base_url('gallery/add_image/'.$data_edit['id'])?>" id="add-image" enctype="multipart/form-data" class="form-horizontal">
	<div class="form-group"> 
		<div class="col-sm-12">
			<div class="show_error"></div>
			<div class="row"> 
				<div class="col-md-6 col-xs-12">
					<img src="https://getuikit.com/v2/docs/images/placeholder_600x400.svg" alt="User Image" width="100%" height="250px" id="preview_image-add">
				</div>
				<div class="col-md-6 col-xs-12">
					<button type="button" class="btn btn-sm btn-primary" id="btnFile-modal-add"><i class="fa fa-file"></i> Browser File</button>
					<input type="file" class="file" id="imageFile-modal-add" style="display: none;" name="file" accept="image/x-png,image/jpeg,image/jpg" />
					<p class="help-block">Gambar yang diupload disarankan memiliki format PNG, JPG, atau JPEG</p>
				</div>
			</div>
		</div>
	</div>

	<div class="box-footer" align="right">
		<button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
		<button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Tambah</button>
	</div>
</form>

<script type="text/javascript">
	
	$("#btnFile-modal-add").click(function() {
		document.getElementById('imageFile-modal-add').click();
	});

	$("#imageFile-modal-add").change(function() {
		imagePreview_modalAdd(this);
	});

	function imagePreview_modalAdd(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#preview_image-add').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	};

	$("#add-image").submit(function(){
		var form = $(this);
		var mydata = new FormData(this);
		$.ajax({
			type: "POST",
			url: form.attr("action"),
			data: mydata,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend : function(){
				$(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
				form.find(".show_error").slideUp().html("");
			},

			success: function(response, textStatus, xhr) {
				var str = response;
				if (str.indexOf("success") != -1){
					form.find(".show_error").hide().html(response).slideDown("fast");
					setTimeout(function(){ 
						location.reload();
					}, 1000);

					$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
				}else{
					form.find(".show_error").hide().html(response).slideDown("fast");
					$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				console.log(xhr);
				$(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
				form.find(".show_error").hide().html(xhr).slideDown("fast");
			}
		});
		return false;
	});
</script>