<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $tbl_merchandise['title'] ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Project</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-10">
                <div class="box">
                    <div class="box-header">
                        <h5 class="box-title">
                            Ubah Detail Gambar Proyek
                        </h5>
                    </div>
                    <div class="box-body">
                        <div class="show_error"></div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-body">
                                        <table class="table table-bordered" style="width: 100%">
                                            <thead style="font-weight: bold;">
                                                <tr>
                                                    <th style="width: 300px">Gambar</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_image_open">
                                                <?php
                                                if ($file_detail) {
                                                    $i = 1;
                                                    foreach ($file_detail as $img) {
                                                        ?>
                                                        <tr id="detail_image_edit">
                                                            <td>
                                                                <img id="image_previewDetail-<?= $i ?>" src="<?= base_url() . $img['dir'] ?>" alt="User Image" height="150px" style="margin: 15px">
                                                            </td>
                                                            <td>
                                                                <a href="<?= base_url('merchandise/editOneImage/') . $img['id'] ?>">
                                                                    <button type="submit" class="btn btn-primary btn-send"><i class="fa fa-save"></i> Ubah Detail Gambar</button>
                                                                </a>
                                                                <button type="button" class="btn btn-danger btn-send" data-toggle="modal" data-target="#modal-delete-imageDetail-<?= $i ?>"><i class="fa fa-trash"></i> Hapus Detail Gambar</button>
                                                                <div class="modal modal-default fade" id="modal-delete-imageDetail-<?= $i ?>" style="display: none;">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-red">
                                                                                <h4 class="modal-title" align="center"><i class="fa fa-image"></i> Hapus Detail Gambar</h4>
                                                                            </div>
                                                                            <div class="modal-body" align="center">
                                                                                <h3>Anda Yakin Ingin Menghapus Gambar Ke-<?= $i ?></h3>
                                                                                <div class="box-footer" align="center">
                                                                                    <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                                                                                    <a href="<?= base_url('merchandise/delete_image/' . $img['id']) ?>">
                                                                                        <button type="button" class="btn btn-danger btn-send"><i class="fa fa-trash"></i> Hapus</button>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $i++;
                                                    }
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="2" align="center" id="btn_image_add">
                                                    <a href="<?= base_url('merchandise/edit/' . $tbl_merchandise['id']) ?>">
                                                        <button type="button" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Kembali</button>
                                                    </a>
                                                    <?php
                                                    $project_image = $this->mymodel->selectWithQuery("SELECT count(id) as count FROM FILE WHERE table_id = " . $tbl_merchandise['id'] . " AND file.table = 'tbl_merchandise_detail'");
                                                    ?>
                                                    <?php if ($project_image[0]['count'] == 3) {
                                                        echo '<button type="button" class="btn btn-sm btn-primary" disabled><i class="fa fa-file"></i> Detail Gambar Tidak bisa lebih dari 3 Gambar</button>';
                                                    } else {
                                                        echo '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add-image" ><i class="fa fa-file"></i> Tambah Gambar Detail</button>';
                                                    } ?>
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-image"><i class="fa fa-trash"></i> Hapus Semua Gambar</button>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal modal-default fade" id="modal-add-image" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" align="center"><i class="fa fa-image"></i> Tambah Detail Gambar</h4>
            </div>
            <div class="modal-body">
                <?php $this->load->view('modals/add_images_detail', $tbl_merchandise); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-default fade" id="modal-delete-image" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title" align="center"><i class="fa fa-image"></i> Hapus Semua Detail Gambar</h4>
            </div>
            <div class="modal-body" align="center">
                <h3>Anda Yakin Ingin Menghapus Semua Gambar</h3>
                <div class="box-footer" align="center">
                    <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                    <a href="<?= base_url('merchandise/delete_Allimage/' . $tbl_merchandise['id']) ?>">
                        <button type="button" class="btn btn-danger btn-send"><i class="fa fa-trash"></i> Hapus</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>