<html>
<head>
   <style type="text/css">
    .aturkiri{
        text-align: left;
    }
    .aturkanan{
        text-align: right;
    }
    .aturtengah{
        text-align: center;
    }
    .spesifik {
        font-style: italic;
        word-spacing: 30px;
    }
    .judul {
        font-style: normal;
        font-size: 18px;
    }
    </style>
</head>
<body>
    <p class="judul"> Neraca Saldo </p>
    Periode : <?=date('d F Y', strtotime($tglawal)) . " s/d " . date('d F Y', strtotime($tglakhir)) ?>
    <br />
    <br />

    <table class="table table-striped table-md">
                        <thead class="judul">
                        <tr>
                            <td class="aturkiri" rowspan="2" width="125px">Kode Akun</td>
                            <td class="aturkiri" rowspan="2" width="200px">Keterangan</td>
                            <td class="aturtengah" colspan="2" width="100">Saldo</td>
                        </tr>
                        <tr>
                        <td class="aturkanan" width="50">Debit</td>
                        <td class="aturkanan" width="50">Kredit</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $td = 0;
                        $tk= 0;
                        ?>
                        <?php foreach ($dttransaksi as $key => $value) : ?>
                        <tr>
                            <?php
                            $d = $value->jumdebit;
                            $k = $value->jumkredit;
                            $neraca = $d - $k;

                            if ($neraca < 0) {
                                $kreditnew = abs($neraca);
                                $tk = $tk + $kreditnew;
                            } else {
                                $kreditnew = 0;
                            }

                            if ($neraca > 0) {
                                $debitnew = $neraca;
                                $td = $td + $debitnew;
                            } else {
                                $debitnew = 0;
                            }

                            ?>
                          <td width="125"><?= $value->kode_akun3 ?></td>
                          <td width="200"><?= $value->nama_akun3 ?></td>
                          <td class="aturkanan" width="50"><?= number_format($debitnew,0,",",",") ?></td>
                          <td class="aturkanan" width="50"><?= number_format($kreditnew,0,",",",") ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <tr>
                            <td ></td>
                            <td ></td>
                            <td class="aturkanan" width="50"><?= number_format($td,0,",",",") ?></td>
                            <td class="aturkanan" width="50"><?= number_format($tk,0,",",",") ?></td>
                        </tr>
                      </tfoot>
                      </table>

    <br />
    <?php 
    $tgl = date('l, d-m-y');
    echo $tgl;
    ?>
    <br />
    <br />
    Pimpinan - UMB
    ______________
</body>
</html>