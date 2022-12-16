 <?= $this->extend('layout/backend') ?>
  <?= $this->section('content') ?>
  <title>AKUNTANSI WEB &mdash; JURNAL UMUM</title>

<?= $this->section('content') ?>

<section class="section">
          <div class="section-header">
            <h2> Laporan Jurnal Umum </h2>
          </div>

          <div class="section-body">
            <div class="card-body">
                <form action="<?=site_url('jurnalumum') ?>" method="POST">
                    <?=csrf_field() ?>
                    <div class="row g-3">

                    <div class="col">
                        <input type="date" class="form-control" name="tglawal" value="<?= $tglawal ?>">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="tglakhir" value="<?= $tglakhir ?>">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan </button>
                        <input type="submit" class="btn btn-success" formtarget="_blank" formaction="jurnalumum/cetakjupdf" value="Cetak PDF">
                    </div>
                    </div>
                </form>
            </div>
                  <div class="card-body p-4">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <thead>
                        <tr>
                          <th>Tanggal</th>
                          <th>Keterangan</th>
                          <th>Ref</th>
                          <th>Debit</th>
                          <th>Kredit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dttransaksi as $key => $value) : ?>
                        <tr>
                          <td><?= $value->tanggal ?></td>
                          <td><?= $value->nama_akun3 ?></td>
                          <td><?= $value->kode_akun3 ?></td>
                          <td class="text-right"><?= number_format($value->debit,0,",",",") ?></td>
                          <td class="text-right"><?= number_format($value->kredit,0,",",",") ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                      </table>

                      <div class="card-header">Laporan Grafik</div>
                      <div class="card-body bg-white viewTampilGrafik"></div>
                      
                    </div>
                  </div>
                </div>
          </div>
</section>

<?= $this->endSection() ?>

<script>
    function TampilGrafik() {
        $.ajax({
            type: "post",
            url: "/jurnalumum/TampilGrafikJU",
            data: {
                bulan : '2021-12'
            },
            dataType:"json",
            success: function (response){
                if (response.data) {
                    $('.viewTampilGrafik').html(response.data);
                    
                }

            },

            error: function(xhr,  ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
                
            }

        });
    }

    $(document).ready(function () {
        TampilGrafikJU;

    });
</script>

<?= $this->endSection() ?>