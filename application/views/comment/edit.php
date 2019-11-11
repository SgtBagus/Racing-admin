<form method="POST" action="<?= base_url('comment/update') ?>" id="upload-create" enctype="multipart/form-data">
  <div class="show_error"></div>
  <div class="form-group">
    <label for="form-value">Komentar Anda!</label>
    <textarea class="form-control" placeholder="Masukan Komentar Anda" name="dt[comment]"><?= $tbl_comment['comment'] ?></textarea>
    <input type="hidden" name="id" value="<?= $tbl_comment['id'] ?>">
  </div>
  <hr>
  <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
  <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
</form>
<script type="text/javascript">
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
            location.reload();
         }, 1000);
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
        }else{
          form.find(".show_error").hide().html(response).slideDown("fast");
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
        form.find(".show_error").hide().html(xhr).slideDown("fast");
      }
    });
    return false;
  });
</script>