<?php

namespace App\Controllers;

use App\Models\ModelAkun3;
use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelTransaksi;
use App\Controllers\BaseController;
use TCPDF;

class JurnalUmum extends BaseController
{
    function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->objtransaksi = new ModelTransaksi();
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
        $this->objStatus = new ModelStatus();
    }

    public function index()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $rowdata = $this->objtransaksi->get_jurnalumum($tglawal, $tglakhir);
        $i= 0;
        $temp1 = '';
        $temp2 = '';

        foreach($rowdata as $row){
            $tgl = ($temp1 == $row->tanggal && $temp2 == $row->kwitansi) ? '' : $row->tanggal;
            $temp1 = $row->tanggal;
            $temp2 = $row->kwitansi;
            $rowdata[$i]->tanggal = $tgl;
            $i++;
        }

        $data['dttransaksi'] = $rowdata;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        return view('jurnalumum/index', $data);
    }

    public function cetakjupdf()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $rowdata = $this->objtransaksi->get_jurnalumum($tglawal, $tglakhir);
        $i= 0;
        $temp1 = '';
        $temp2 = '';

        foreach($rowdata as $row){
            $tgl = ($temp1 == $row->tanggal && $temp2 == $row->kwitansi) ? '' : $row->tanggal;
            $temp1 = $row->tanggal;
            $temp2 = $row->kwitansi;
            $rowdata[$i]->tanggal = $tgl;
            $i++;
        }

        $data = [
            'dttransaksi' => $rowdata,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
        ];

        $html = view('jurnalumum/cetakjupdf', $data);

        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set margins
        $pdf->SetMargins(30,3,3);
        
        // set font
        $pdf->SetFont('times', '', 10);

        // add a page
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');

        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('appliaction/pdf');
        $pdf->Output('jurnalumum.pdf', 'I');
    }

    function TampilGrafikJU(){
        $bulan = $this->request->getPost('bulan');

        $db = \config\Database::connect();

        $query = $db->query("SELECT created_at AS created_at, debit FROM `tbl_nilai` WHERE debit ORDER BY debit ASC");

    }
}
