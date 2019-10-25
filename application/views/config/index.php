<div class="content-wrapper">
    <section class="content-header">
        <h1>Config</h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Config</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-body">
                    <form method="POST" action="config/update/<?= $marquee['id'] ?>" id="upload-create" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">
                            <div class="show_error"></div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Marquee</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Masukan Marquee ..." name="dt[value]" value="<?= $marquee['value'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer" align="right">
                                <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
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
            setTimeout(function() {}, 1000);
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
