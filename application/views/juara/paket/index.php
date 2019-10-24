<div class="content-wrapper">
    <section class="content-header">
        <h1>Paket Juara - <?= $tbl_event['title'] ?> <small> <?= $tbl_paket['title'] ?> </small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Paket Detail</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a href="javascript::void(0)" onclick="create()">
                                        <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Juara</button>
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
    </section>
</div>
<div class="modal fade bd-example-modal-sm" tabindex="-1" tbl_paket_detail="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-form">
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
<div class="modal fade bd-example-modal-sm" tabindex="-1" tbl_paket_detail="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="upload-delete" action="<?= base_url('juara/pakedetaildelete') ?>">
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
            '       <th>Team</th>' +
            '       <th>Raider</th>' +
            '       <th>Number</th>' +
            '       <th>Keterangan</th>' +
            '       <th style="width:150px"></th>' +
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
                "url": "<?= base_url('juara/detailpaketjson/'.$tbl_paket['id']) ?>",
                "type": "POST"
            },

            columns: [
                {
                    "data": "id",
                }, 
                {
                    "data": "id_team"
                }, 
                {
                    "data": "id_raider"
                }, 
                {
                    "data": "number"
                }, 
                {
                    "data": "keterangan"
                },
                {
                    "data": "view",
                    "orderable": false
                }
            ],
            order: [[3, 'asc']],
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
        $("#title-form").html('Edit Juara');
        $("#load-form").load("<?= base_url('juara/detailpaketedit/') ?>" + id);
    }

    function create() {
        $("#load-form").html('loading...');
        $("#modal-form").modal();
        $("#title-form").html('Tambah Juara');
        $("#load-form").load("<?= base_url('juara/detailpaketcreate/').$tbl_paket['id']?>");
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
            error: function(xhr, textStatus, errorThrown) {
            }
        });
        return false;
    });
</script>