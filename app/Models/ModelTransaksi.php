<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksi extends Model
{
    protected $table            = 'tbl_transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kwitansi', 'tanggal', 'deskripsi', 'ketjurnal'];
    // protected $DBGroup          = 'default';
    // protected $useAutoIncrement = true;
    // protected $insertID         = 0;
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;

    // Dates
    // protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    public function noKwitansi()
    {
        $number = $this->db->table('tbl_transaksi')->select('RIGHT(tbl_transaksi.kwitansi,4) as kwitansi', FALSE)
        ->orderBy('kwitansi', 'DESC')->limit(1)->get()->getRowArray();
        if($number == null){
            $no = 1;
        }else{
            $no = intval($number['kwitansi']) + 1;
        }
        $nomor_kwitansi = str_pad($no,4,"0",STR_PAD_LEFT);
        return $nomor_kwitansi;
    }

    public function get_jurnalumum($tglawal, $tglakhir)
    {
        $sql = $this->db->table('tbl_nilai')
        ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
        ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
        ->orderBy('id_nilai');
        if($tglawal && $tglakhir){
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
    return $sql->get()->getResultObject();
    }

    public function get_posting($tglawal, $tglakhir, $kode_akun3)
    {
        $sql = $this->db->table('tbl_nilai')
        ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
        ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
        ->orderBy('akun3s.kode_akun3');
        if($tglawal && $tglakhir){
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir)->where('tbl_nilai.kode_akun3=', $kode_akun3);
        }
        return $sql->get()->getResultObject();
    }

    public function get_jpenyesuaian($tglawal, $tglakhir)
    {
        $sql = $this->db->table('tbl_nilaipenyesuaian')
        ->join('tbl_penyesuaian', 'tbl_penyesuaian.id_penyesuaian=tbl_nilaipenyesuaian.id_penyesuaian')
        ->join('akun3s', 'akun3s.kode_akun3=tbl_nilaipenyesuaian.kode_akun3')
        ->selectSum('debit', 'jumdebit')
        ->selectSum('kredit', 'jumkredit')
        ->select('akun3s.kode_akun3, akun3s.nama_akun3, tbl_penyesuaian.tanggal')
        ->groupBy('akun3s.kode_akun3');

        if($tglawal && $tglakhir){
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
    $query = $sql->get()->getResultObject();
    return $query;

    }

    public function get_neracasaldo($tglawal, $tglakhir)
    {
        $sql = $this->db->table('tbl_nilai')
        ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
        ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
        ->selectSum('debit', 'jumdebit')
        ->selectSum('kredit', 'jumkredit')
        ->select('akun3s.kode_akun3, akun3s.nama_akun3, tbl_transaksi.tanggal, debit, kredit')
        ->groupBy('akun3s.kode_akun3');

        if($tglawal && $tglakhir){
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
        $query = $sql->get()->getResultObject();
        return $query;
    }

    public function get_neracalajur($tglawal, $tglakhir)
    {
        $sql = $this->db->query("SELECT * FROM(
            SELECT tbak.nama_akun3, tbl.kode_akun3, tb3.tanggal
        )");
    }
}
