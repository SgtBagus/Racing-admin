<div class="content-wrapper">
  <section class="content-header">
    <h1><?= $tbl_merchandise['title'] ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Project</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-10">
        <div class="box">
          <div class="box-body">
            <div class="show_error"></div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <div class="box-body">
                    <form method="POST" action="<?= base_url('merchandise/edit_images/'.$file_detail['id'])?>" id="add-image" enctype="multipart/form-data" class="form-horizontal">
                      <div class="show_error"></div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <div class="row"> 
                            <div class="col-md-4 col-xs-12">
                              <img src="<?= base_url().$file_detail['dir'] ?>" alt="User Image" width="100%" height="100%" id="preview_image-edit">
                            </div>
                            <div class="col-md-8 col-xs-12">
                              <button type="button" class="btn btn-sm btn-primary" id="btnFile-modal-edit"><i class="fa fa-file"></i> Browser File</button>
                              <input type="file" class="file" id="imageFile-modal-edit" style="display: none;" name="file" accept="image/x-png,image/jpeg,image/jpg" />
                              <p class="help-block">Gambar yang diupload disarankan memiliki format PNG, JPG, atau JPEG</p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="box-footer" align="right">
                        <a href="<?= base_url('merchandise/editImage/'.$tbl_merchandise['id'])?>">
                          <button type="button" class="btn btn-info"><i class="fa fa-close"></i> Tutup</button>
                        </a>
                        <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-edit"></i> Ubah</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<script type="text/javascript">

  $("#btnFile-modal-edit").click(function() {
    document.getElementById('imageFile-modal-edit').click();
  });

  $("#imageFile-modal-edit").change(function() {
    imagePreview_modalEdit(this);
  });

  function imagePreview_modalEdit(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#preview_image-edit').attr('src', e.target.result);
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
            location.href = '<?= base_url("merchandise/editImage/").$tbl_merchandise['id'] ?>';
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