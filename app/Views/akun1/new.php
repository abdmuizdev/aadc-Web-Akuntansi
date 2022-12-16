<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
          <div class="section-header">
            <!-- <h1>Blank Page</h1> -->
            <a href="<?= site_url('akun1') ?>" class="btn btn-primary"> Add New</a>
          </div>

          <div class="section-body">
            <!-- INI DINAMIS -->
            <div class="card">
                  <div class="card-header">
                    <h4>Tambah Data Akun 1</h4>
                  </div>
                  <div class="card-body p-4">
                    <!-- Tempat mengetik -->

                    <form method="post" action="<?= site_url('akun1') ?>">
                    <?= csrf_field() ?>
                    <div class="form-group">
                      <?php $validation = \Config\Services::validation(); ?>
                      <label>Kode Akun 1</label>
                      <input type="text" class="form-control" name="kode_akun1" placeholder="Kode Akun">
                      <div class="invalid-feedback">
                        <?=$validation->getError('kode_akun1')?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Nama Akun 1</label>
                      <input type="text" class="form-control" name="nama_akun1" placeholder="Nama Akun">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Save</button>
                      <button type="reset" class="btn btn-secondary"> Reset</button>
                    </div>
                    </form>
                  </div>
                  </div>
                </div>
          </div>
</section>

<?= $this->endSection() ?>