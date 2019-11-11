 <div class="content-wrapper">
  <section class="content-header">
    <h1> Gallery </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Gallery</li>
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
                  <a href="<?= base_url('gallery/create') ?>">
                    <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Gambar</button>
                  </a>
                  <a href="<?= base_url('master/imagegroup') ?>">
                    <button type="button" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Lihat Kategori Gambar</button>
                  </a>
                  <a href="<?= base_url('fitur/ekspor/tbl_event') ?>" target="_blank">
                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> Ekspor Event</button>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="show_error"></div>
            <div class="table-responsive">
              <table id="datatable" class="table table-bordered table-striped" >
                <thead>
                  <tr class="bg-success">
                    <th>No</th>
                    <th>Kategori Gambar</th>
                    <th>Cover Kategori</th>
                    <th>Jumlah Gambar</th>
                    <th>Jumlah Komentar</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; foreach ($master_imagegroup as $row) {
                    $main_image = $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'master_gallery'));
                    $imagecount = $this->mymodel->selectWithQuery('SELECT count(id) as imagecount from tbl_gallery WHERE status = "ENABLE" AND imagegroup_id = '.$row['id']);
                    $commentcount = $this->mymodel->selectWithQuery('SELECT count(id) as commentcount from tbl_comment WHERE status = "ENABLE" AND imagegroup_id = '.$row['id']);?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $row['value'] ?></td>
                      <td>
                        <img src="<?= $main_image['url']?>" width="250px" height="180px">
                      </td>
                      <td><b><?= $imagecount[0]['imagecount'] ?></b> Gambar</td>
                      <td>
                        <b><?= $commentcount[0]['commentcount'] ?></b> Komentar
                        <hr>
                        <div class="row" align="center">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-approve btn-sm btn-sm btn-primary" onclick="comment(<?= $row['id'] ?>)"><i class="fa fa-comment-o"></i> Tambah Komentar</button>
                            <button type="button" class="btn btn-reject btn-sm btn-sm btn-info" onclick="viewcomment(<?= $row['id'] ?>)"><i class="fa fa-eye"></i> Lihat Semua Komentar</button>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-primary" onclick="edit(<?=$row['id']?>)">
                            <i class="fa fa-edit"></i>
                          </button>
                          <?php if($this->session->userdata('role_id') == '17'){ ?>
                            <button type="button" onclick="hapus(<?=$row['id']?>)" class="btn btn-sm btn-danger">
                              <i class="fa fa-trash-o"></i>
                            </button>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <?php $i++; } ?>
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
        <form id="upload-delete" action="<?= base_url('gallery/delete') ?>" method="POST">
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

  <div class="modal fade bd-example-modal-sm" tabindex="-1" master_motor="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-form">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title-form" ></h5>
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

  <script type="text/javascript">
    loadtable($("#select-status").val());

    function comment(id) {
      $("#load-form").html('loading...');
      $("#modal-form").modal();
      $("#title-form").html('Tambah Komentar');
      $("#load-form").load("<?= base_url('comment/create/') ?>"+id);
    }

    function edit(id) {
      location.href = "<?= base_url('gallery/edit/') ?>"+id;
    }

    function viewcomment(id) {
      location.href = "<?= base_url('comment?imagegroupid=') ?>"+id;
    }

    function hapus(id) {
      $("#modal-delete").modal('show');
      $("#delete-input").val(id);
    }

 </script>