<div class="content-wrapper">
  <section class="content-header">
    <h1><?= $master_imagegroup['value'] ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Gallery</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h5 class="box-title">
              Edit Project
            </h5>
          </div>
          <?php $data['data_edit'] = $master_imagegroup; 
          $data['file'] = $file; 
          $this->load->view('gallery/_form', $data) ?>
        </div>
      </div>
    </div>
  </section>
</div>