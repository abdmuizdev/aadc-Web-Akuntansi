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
        font-style: italic;
        font-size: 18px;
    }
    </style>
    </head>
    <body>
    <p class="judul"> Jurnal Umum </p>
    Periode : <?=date('d F Y', strtotime($tglawal)) . " s/d " . date('d F Y', strtotime($tglakhir)) ?>
    <br />
    <br />

    <table border= "0.1px" class="table tab-bordered">
        <thead>
        <tr>
            <td class="aturtengah" rowspan="2" >Tanggal</td>
            <td class="aturtengah" rowspan="2" >Keterangan</td>
            <td class="aturtengah" rowspan="2" >Ref</td>
            <td class="aturtengah" rowspan="2" >Debit</td>
            <td class="aturtengah" rowspan="2" >Kredit</td>
            <td class="aturtengah" colspan="2" >Saldo</td>
        </tr>
        <tr>
            <td class="aturtengah" >Debit</td>
            <td class="aturtengah">Kredit</td>
        </tr>
        </thead>
        <tbody>
            <?php 
            $dbt = 0;

            ?>
        <?php foreach ($dttransaksi as $key => $value) : ?>
            <?php 
            if($value->debit){
                $dbt = $dbt + $value->debit;
            } else{
                $dbt = $dbt - $value->kredit;
            }

            $ndbt1 = $dbt >= 0 ? $dbt : 0;
            $ndbt2 = $dbt <= 0 ? $dbt : 0;

            ?>
        <tr>
            <td class="aturtengah" ><?= $value->tanggal ?></td>
            <td class="aturtengah" ><?= $value->kode_akun3 ?></td>
            <td class="aturkiri" ><?= $value->ketjurnal ?></td>
            <td class="aturkanan" ><?= number_format($value->debit, 0,",",",") ?></td>
            <td class="aturkanan" ><?= number_format($value->kredit, 0,",",",") ?></td>
            <td class="aturkanan" ><?= number_format($ndbt1, 0,",",",") ?></td>
            <td class="aturkanan" ><?= number_format(abs($ndbt2), 0,",",",") ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
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