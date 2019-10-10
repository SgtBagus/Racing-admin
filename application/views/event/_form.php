<?php

$action = base_url('event/store');

if($data_edit){
  $action = base_url('event/update');
}

?>

<form method="POST" action="<?= $action ?>" id="upload-create" enctype="multipart/form-data" class="form-horizontal">
  <div class="box-body">
    <div class="show_error"></div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Judul Event*</label>
      <div class="col-sm-9">
        <?php if($data_edit){echo '<input type="hidden" name="dt[id]" value="'.$data_edit['id'].'">'; }  ?>
        <input type="text" class="form-control" placeholder="Masukan Kota Proyek ..." name="dt[title]" <?php if($data_edit){echo "value='".$data_edit['title']."'"; }  ?>>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Gambar Event</label>
      <div class="col-sm-9">
        <div class="row">
          <div class="col-md-5 col-xs-12">
            <?php
            if($file){
              if($file['dir']!=""){
                ?>
                <img src="<?= base_url().$file['dir'] ?>" alt="User Image" width="100%" height="250px" id="preview_image">
                <?php
              }
            } else{
              ?>
              <img src="<?= base_url('webfiles/event/event_default.jpg') ?>" alt="User Image" width="100%" height="250px" id="preview_image">
              <?php
            }?>
          </div>
          <div class="col-md-7 col-xs-12">
            <button type="button" class="btn btn-sm btn-primary" id="btnFile"><i class="fa fa-file"></i> Browser File</button>
            <input type="file" class="file" id="imageFile" style="display: none;" name="file" accept="image/x-png,image/jpeg,image/jpg" />
            <p class="help-block">Gambar yang diupload disarankan memiliki format PNG, JPG, atau JPEG</p>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Event*</label>
      <div class="col-sm-9">
        <input type="text" name="dt[tglevent]" class="form-control tgl" placeholder="Masukan Tanggal Event" <?php if ($data_edit) { ?>value="<?= date("d-m-Y", strtotime($data_edit['tglevent'])); ?>" <?php } ?>>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Nomor yang dapat dihubungi</label>
      <div class="col-sm-9">
        <input type="text" name="dt[phone]" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask
        <?php if($data_edit){echo "value='".$data_edit['phone']."'"; }  ?>>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Deskripsi </label>
      <div class="col-sm-9">
        <textarea class="textarea form-control" name="dt[deskripsi]"><?php if($data_edit){echo $data_edit['deskripsi']; }  ?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Kota Event*</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukan Kota Event ..." name="dt[kota]" <?php if($data_edit){echo "value='".$data_edit['kota']."'"; }  ?>>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Alamat Lengkap Event*</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="dt[alamat]" rows="5"><?php if($data_edit){echo $data_edit['alamat']; }  ?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Dalam Satu Team</label>
      <div class="col-sm-4">
        <div class="input-group">
          <div class="input-group-addon">
            Minim Raider
          </div>
          <input type="number" name="dt[minraider]" class="form-control" placeholder="Masukan Minim Raider" <?php if($data_edit){echo "value='".$data_edit['minraider']."'"; }else{ echo "value = '1'"; }?>>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="input-group">
          <div class="input-group-addon">
            Maximal Raider
          </div>
          <input type="number" name="dt[maxraider]" class="form-control" placeholder="Masukan Minim Raider" <?php if($data_edit){echo "value='".$data_edit['maxraider']."'"; }else{ echo "value = '1'"; }?>>
        </div>
      </div>
    </div>
    <div class="show_error"></div>
  </div>
  <div class="box-footer" align="right">
    <a href="<?= base_url('event') ?> ">
      <button type="button" class="btn btn-info"><i class="fa fa-stars"></i> Data Event</button>
    </a>
    <?php if($data_edit){ ?>
      <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-edit"></i> Edit</button>
    <?php } else { ?>
      <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
    <?php } ?>
  </div>
</form>
<script type="text/javascript">
  $(function () {

    $("#upload-create").submit(function(){
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
              window.location.href = "<?= base_url('event') ?>";
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
  });

  $('.textarea').wysihtml5();
</script>
