<div class="content-wrapper">
    <section class="content-header">
        <h1> Dokumentasi Event </h1>
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
                                        <th>Juara Raider Umum Saat ini</th>
                                        <th>Juara Point Umum Saat ini</th>
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
                                            <td>Raider 1</td>
                                            <td>23612</td>
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
<script type="text/javascript">
    loadtable($("#select-status").val());

    function view(id) {
        location.href = "<?= base_url('eventdokumentasi/view/') ?>" + id;
    }
</script>