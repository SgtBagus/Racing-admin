<div class="content-wrapper">
    <section class="content-header">
        <h1> Data Juara </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Juara</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="show_error"></div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-success">
                                        <th style="width:20px">No</th>
                                        <th>Judul Event</th>
                                        <th>Tgl Event Dimulai</th>
                                        <th>Tgl Event Berakhir</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($tbl_event as $row) {
                                        $file =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'tbl_event'));
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $row['title'] ?></td>
                                            <td><?= date('d M Y', strtotime($row['tgleventStart'])) ?></td>
                                            <td><?= date('d M Y', strtotime($row['tgleventEnd'])) ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info" onclick="view(<?= $row['id'] ?>)">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade bd-example-modal-sm" tabindex="-1" tbl_event="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="upload-delete" action="<?= base_url('event/delete') ?>" method="POST">
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

<div class="modal fade bd-example-modal" tabindex="-1" tbl_event="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-start">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="upload-start" action="<?= base_url('event/start') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Mulai Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="upload-input">
                    <div class="form-group">
                        <label>URL Link Live jika tersedia</label>
                        <input type="text" class="form-control" placeholder="Masukan Link Live Event" name="dt[live_url]">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-check-circle"></i> Mulai Event</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadtable($("#select-status").val());

    function view(id) {
        location.href = "<?= base_url('juara/view/') ?>" + id;
    }
</script>