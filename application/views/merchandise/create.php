<div class="content-wrapper">
  <section class="content-header">
    <h1> Merchandise </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Merchandise</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h5 class="box-title">
              Tambah Merchandise
            </h5>
          </div>
          <?php $data['data_edit'] = ''; 
          $data['file'] = ''; 
          $this->load->view('merchandise/_form', $data) ?>
        </div>
      </div>
    </div>
  </section>
</div>