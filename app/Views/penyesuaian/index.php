 <?= $this->extend('layout/backend') ?>
  <?= $this->section('content') ?>
  <title>AKUNTANSI WEB &mdash; TRANSAKSI</title>

<?= $this->section('content') ?>

<section class="section">
          <div class="section-header">
            <a href="<?= site_url('penyesuaian/new') ?>" class="btn btn-primary"> Add New</a>
          </div>
          <!-- Ini untuk menangkap session succes -->
          <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <div class="alert-body">
              <strong></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <?= session()->getFlashdata('success'); ?>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <div class="alert-body">
              <strong></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <?= session()->getFlashdata('error'); ?>
            </div>
          <?php endif; ?>

          <div class="section-body">
            <!-- INI DINAMIS -->
            <div class="card">
                  <div class="card-header">
                    <h4>Data Penyesuaian</h4>
                  </div>
                  <div class="card-body p-4">
                    <div class="table-responsive">
                      <table class="table table-striped table-md" id="myTable">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Deskripsi</th>
                          <th>Nilai</th>
                          <th>Waktu</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dtpenyesuaian as $key => $value) : ?>
                        <tr>
                          <td><?= $key + 1 ?></td>
                          <td><?= $value->tanggal ?></td>
                          <td><?= $value->deskripsi ?></td>
                          <td><?= $value->nilai ?></td>
                          <td><?= $value->waktu ?></td>
                          <td class="text-center" style="width:20%" >
                          <a href="<?= site_url('penyesuaian/' . $value->id_penyesuaian ) ?>" class="btn btn-info btn-small"> <i class="fas fa-bars btn-small"></i> Detail </a>
                            <a href="<?= site_url('penyesuaian/' . $value->id_penyesuaian . '/edit') ?>" class="btn btn-warning"> <i class="fas fa-pencil-alt btn-small"></i> Edit </a>

                            <form action="<?= site_url('penyesuaian/' . $value->id_penyesuaian) ?>" method="post" id="del-<?=$value->id_penyesuaian?>" class="d-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-small" data-confirm="Hapus Data! | Apakah Anda Yakin ?" data-confirm-yes="hapus(<?=$value->id_penyesuaian?>)"><i class="fas fa-trash"> Delete </i></button>
                            </form>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                      </table>
                    </div>
                  </div>
                </div>
          </div>
</section>
<?= $this->endSection() ?>
<?= $this->endSection() ?>