<div class="content-wrapper">
    <section class="content-header">
        <h1> Pendaftar Event <small><?= $tbl_event['title'] ?></small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tim</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xm-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <center>
                            <img src="<?= $file_event['url'] ?>" style="width: 550px; height: 350px; border-radius: 20px" class="img img-thumbnail">
                        </center>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Event</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Event</label>
                                                    <input type="text" class="form-control" value="<?= $tbl_event['title'] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Nomor Petanggung Jawab Event</label>
                                                            <input type="text" class="form-control" value="<?= $tbl_event['phone'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tanggal Dimulai</label>
                                                            <input type="text" class="form-control" value="<?= date('d M Y', strtotime($tbl_event['tgleventStart'])) ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tanggal Selesai</label>
                                                            <input type="text" class="form-control" value="<?= date('d M Y', strtotime($tbl_event['tgleventEnd'])) ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Minim Rider</label>
                                                            <input type="text" class="form-control" value="<?= $tbl_event['minraider'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Maximal Rider</label>
                                                            <input type="text" class="form-control" value="<?= $tbl_event['maxraider'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Kota Event</label>
                                                            <input type="text" class="form-control" value="<?= $tbl_event['kota'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Alamat Lengkap Event</label>
                                                            <textarea class="form-control" readonly rows="5px"><?= $tbl_event['alamat'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Paket Juara</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="pull-right">
                                        <a href="javascript::void(0)" onclick="create()">
                                            <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Paket Juara</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="show_error"></div>
                            <div class="table-responsive">
                                <div id="load-table"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" align="center">
            <a href="<?= base_url('eventregister') ?>">
                <button type="button" class="btn btn-sm btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button>
            </a>
        </div>
    </section>
</div>

<div class="modal fade bd-example-modal-sm" tabindex="-1" tbl_paket="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-form">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-form"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="load-form"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" tabindex="-1" tbl_paket="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="upload-delete" action="<?= base_url('juara/paketdelete') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete-input">
                    <p>Are you sure to delete this data?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-send">Yes, Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function loadtable(status) {

        var table = '<table class="table table-bordered" id="mytable">' +
            '     <thead>' +
            '     <tr class="bg-success">' +
            '       <th style="width:20px">No</th>' +
            '       <th style="width:1000px">Judul Paket Juara</th>' +
            '       <th></th>' +
            '     </tr>' +
            '     </thead>' +
            '     <tbody>' +
            '     </tbody>' +
            ' </table>';
        $("#load-table").html(table)

        var t = $("#mytable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input').off('.DT').on('keyup.DT', function(e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url('juara/paketjson/').$tbl_event['id'] ?>",
            },
            columns: [{
                    "data": "id",
                    "orderable": false
                },
                {
                    "data": "title"
                },
                {
                    "data": "view",
                    "orderable": false
                }
            ],
            order: [
                [1, 'asc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
    }

    loadtable($("#select-status").val());

    function edit(id) {
        $("#load-form").html('loading...');
        $("#modal-form").modal();
        $("#title-form").html('Edit Tbl Paket');
        $("#load-form").load("<?= base_url('juara/paketedit/') ?>" + id + "/<?= $tbl_event['id'] ?>");
    }
    
    function view(id) {
        location.href = "<?= base_url('juara/paket/') ?>" + id + '/<?=$tbl_event['id']?>';
    }

    function create() {
        $("#load-form").html('loading...');
        $("#modal-form").modal();
        $("#title-form").html('Create Tbl Paket');
        $("#load-form").load("<?= base_url('juara/paketcreate/') . $tbl_event['id'] ?>");
    }

    function hapus(id) {
        $("#modal-delete").modal('show');
        $("#delete-input").val(id);
    }

    $("#upload-delete").submit(function() {
        event.preventDefault();
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
                $(".show_error").slideUp().html("");
            },
            success: function(response, textStatus, xhr) {
                var str = response;
                if (str.indexOf("success") != -1) {
                    $(".show_error").hide().html(response).slideDown("fast");
                    $(".btn-send").removeClass("disabled").html('Yes, Delete it').attr('disabled', false);
                } else {
                    setTimeout(function() {
                        $("#modal-delete").modal('hide');
                    }, 1000);
                    $(".show_error").hide().html(response).slideDown("fast");
                    $(".btn-send").removeClass("disabled").html('Yes , Delete it').attr('disabled', false);
                    loadtable($("#select-status").val());
                }
            },
            error: function(xhr, textStatus, errorThrown) {}
        });
        return false;
    });
</script>