<form method="POST" action="<?= base_url('juara/paketupdate') ?>" id="upload-create" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $tbl_paket['id'] ?>">
    <div class="show_error"></div>
    <div class="form-group">
        <label for="form-title">Judul Paket Juara</label>
        <input type="text" class="form-control" id="form-title" placeholder="Masukan Title" name="dt[title]" value="<?= $tbl_paket['title'] ?>">
    </div>
    <div class="form-group">
        <label for="form-title">File Juara</label>
        <br>
        <?php
        if ($rule) {
            $types = explode("/", $rule['mime']);
            ?>
            <i class="fa fa-file fa-5x text-danger"></i> <?= $rule['name'] ?>
            <br>
            <div class="col-md-12">
                <a href="<?= base_url($rule['dir']) ?>" target="_blank">
                    <button type="button" class="btn btn-send btn-info btn-sm btn-sm btn-primary"><i class="fa fa-eye"></i></button>
                </a>
                <a href="<?= base_url('download/downloadPDFPaket/' . $rule['id']) ?>">
                    <button type="button" class="btn btn-send btn-warning btn-sm btn-sm btn-danger"><i class="fa fa-download"></i></button>
                </a>
            </div>
            <br>
            <br>
        <?php
        } ?>
        <input type="file" class="form-control" name="rule">
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Save</button>
    <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
</form>
<script type="text/javascript">
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
                        $("#load-table").html('');
                        loadtable($("#select-status").val());
                        $("#modal-form").modal('hide');
                    }, 1000);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                } else {
                    form.find(".show_error").hide().html(response).slideDown("fast");
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                }
            },

            error: function(xhr, textStatus, errorThrown) {
                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled', false);
                form.find(".show_error").hide().html(xhr).slideDown("fast");
            }
        });
        return false;
    });
</script>