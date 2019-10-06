<div class="content-wrapper">
  <section class="content-header">
    <h1><?= $master_imagegroup['value'] ?></h1>
    <?php var_dump()?>
    <ol class="breadcrumb">
      <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Gallery</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h5 class="box-title">Tambah Gambar</h5>
          </div>
          <form method="POST" action="<?= base_url('gallery/add_image/'.$master_imagegroup['id'])?>" id="add-image" enctype="multipart/form-data" class="form-horizontal">
            <div class="box-body">
              <div class="show_error"></div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Groub Gambar*</label>
                <div class="col-sm-9">
                  <select class="form-control select2" name="dt[imagegroup_id]" disabled="disabled">
                    <option value="">-- Pilih Kategori Gambar --</option>
                    <?php
                    $master_imagegroup = $this->mymodel->selectData("master_imagegroup");
                    foreach ($master_imagegroup as $key => $value) {
                      ?>
                      <option value="<?= $value['id'] ?>" <?php if($tbl_gallery['imagegroup_id'] == $value['id']) { echo "selected"; } ?> ><?= $value['value'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group"> 
                <label for="inputEmail3" class="col-sm-3 control-label">Groub Gambar*</label>
                <div class="col-sm-9">
                  <div class="col-md-6 col-xs-12">
                    <img src="https://getuikit.com/v2/docs/images/placeholder_600x400.svg" alt="User Image" width="100%" height="250px" id="preview_image-add">
                  </div>
                  <div class="col-md-6 col-xs-12">
                    <button type="button" class="btn btn-sm btn-primary" id="btnFile-modal-add"><i class="fa fa-file"></i> Browser File</button>
                    <input type="file" class="file" id="imageFile-modal-add" style="display: none;" name="file" accept="image/x-png,image/jpeg,image/jpg" />
                    <p class="help-block">Gambar yang diupload disarankan memiliki format PNG, JPG, atau JPEG</p>
                    <div class="col-md-10">
                      <div class="form-group">
                        <label>Judul Gambar*</label>
                        <input type="text" class="form-control" placeholder="Masukan Nama gambar"name="dt[title]">
                      </div>
                      <div class="form-group">
                        <label>Caption Gambar</label>
                        <textarea class="form-control" rows="5" name="dt[caption]"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer" align="right">
              <a href="<?= base_url('gallery/edit/').$master_imagegroup['id'] ?>">
                <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
              </a>
              <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
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
            window.location.href = "<?= base_url('gallery/')?>";
          }, 1000);

          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Tambah').attr('disabled',false);
        }else{
          form.find(".show_error").hide().html(response).slideDown("fast");
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Tambah').attr('disabled',false);
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr);
        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Tambah').attr('disabled',false);
        form.find(".show_error").hide().html(xhr).slideDown("fast");
      }
    });
    return false;
  });
</script>