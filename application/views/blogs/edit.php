<div class="content-wrapper">
  <section class="content-header">
    <h1><?= $tbl_blog['title'] ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Blog / Informasi</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h5 class="box-title">
              Edit Blog / Informasi
            </h5>
          </div>
          <?php $data['data_edit'] = $tbl_blog; 
          $data['file'] = $file; 
          $this->load->view('blogs/_form', $data) ?>
        </div>
      </div>
    </div>
  </section>
</div>