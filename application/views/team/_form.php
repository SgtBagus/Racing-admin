<?php
$action = base_url('team/store');
if ($data_edit) {
  $action = base_url('team/update');
}
?>

<form method="POST" action="<?= $action ?>" id="upload-create" enctype="multipart/form-data" class="form-horizontal">
  <div class="box-body">
    <div class="show_error"></div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Nama team*</label>
      <div class="col-sm-9">
        <?php if ($data_edit) {
          echo '<input type="hidden" name="dt[id]" value="' . $data_edit['id'] . '">';
        }  ?>
        <input type="text" class="form-control" placeholder="Masukan Nama Team ..." name="dt[name]" <?php if ($data_edit) {
                                                                                                          echo "value='" . $data_edit['name'] . "'";
                                                                                                        }  ?>>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Email Team*</label>
      <div class="col-sm-9">
        <input type="email" name="dt[email]" class="form-control" <?php if ($data_edit) {
                                                                    echo "value='" . $data_edit['email'] . "'";
                                                                  }?>>
      </div>
    </div>
    
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Password*</label>
      <div class="col-sm-4">
        <div class="input-group">
          <div class="input-group-addon">
            Password
          </div>
          <input type="password" name="password" class="form-control" placeholder="*****">
        </div>
      </div>
      <div class="col-sm-5">
        <div class="input-group">
          <div class="input-group-addon">
            Konfirmasi Password
          </div>
          <input type="password" name="confirmpassword" class="form-control" placeholder="*****">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Alamat*</label>
      <div class="col-sm-9">
        <textarea name="dt[alamat]" class="form-control" rows="5"><?php if ($data_edit) {
                                                                    echo $data_edit['alamat'];
                                                                  }  ?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Kota Team*</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukan Kota Team ..." name="dt[kota]" <?php if ($data_edit) {
                                                                                                        echo "value='" . $data_edit['kota'] . "'";
                                                                                                      }  ?>>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Nomor Wa*</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="Masukan Kota Team ..." name="dt[nowa]" <?php if ($data_edit) {
                                                                                                        echo "value='" . $data_edit['nowa'] . "'";
                                                                                                      }  ?>>
      </div>
    </div>
    <div class="show_error"></div>
  </div>
  <div class="box-footer" align="right">
    <a href="<?= base_url('team') ?> ">
      <button type="button" class="btn btn-info"><i class="fa fa-stars"></i> Data Team</button>
    </a>
    <?php if ($data_edit) { ?>
      <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-edit"></i> Edit</button>
    <?php } else { ?>
      <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
    <?php } ?>
  </div>
</form>
<script type="text/javascript">
  $(function() {

    $("#upload-create").submit(function() {
      var form = $(this);
      var mydata = new FormData(this);
      $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: mydata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled', true);
          form.find(".show_error").slideUp().html("");
        },

        success: function(response, textStatus, xhr) {
          var str = response;
          if (str.indexOf("success") != -1) {
            form.find(".show_error").hide().html(response).slideDown("fast");
            setTimeout(function() {
              window.location.href = "<?= base_url('team') ?>";
            }, 1000);

            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
          } else {
            form.find(".show_error").hide().html(response).slideDown("fast");
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
          }
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr);
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
          form.find(".show_error").hide().html(xhr).slideDown("fast");
        }
      });
      return false;
    });
  });

  $('.textarea').wysihtml5();
</script>