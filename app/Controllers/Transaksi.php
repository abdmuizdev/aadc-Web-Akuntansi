<?php

namespace App\Controllers;

use App\Models\ModelAkun3;
use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelTransaksi;
use CodeIgniter\RESTful\ResourceController;

class Transaksi extends ResourceController
{

    // inisiasi objek

    function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->objtransaksi = new ModelTransaksi();
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
        $this->objStatus = new ModelStatus();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {        
        $data['dttransaksi'] = $this->objtransaksi->findAll();
        return view('transaksi/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $transaksi = $this->objtransaksi->find($id);
        $akun3= $this->objAkun3->findAll();
        $status = $this->objStatus->findAll();
        $nilai = $this->objNilai->ambilrelasiid($id);
        $data ['dtnilai'] = $nilai;

        if(is_object($transaksi)){
            $data['dtakun3'] = $akun3;
            $data['dtstatus'] = $status;
            $data['dttransaksi'] = $transaksi;

                return view('transaksi/show', $data);
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        return view('transaksi/new');
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data1= [
            //data tbl_transaksi
            // 'kwitansi' => $this->request->getVar('kwitansi'),
            'kwitansi' => $this->objtransaksi->noKwitansi(),

            'tanggal' => $this->request->getVar('tanggal'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'ketjurnal' => $this->request->getVar('ketjurnal'),
        ];
        // simpan data tbl_transaksi
        $this->db->table('tbl_transaksi')->insert($data1);

        // kita ambil ID dari tbl_transaksi
        $id_transaksi = $this->objtransaksi->insertID();
        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debit = $this->request->getVar('debit');
        $kredit = $this->request->getVar('kredit');
        $id_status = $this->request->getVar('id_status');

        for ($i=0; $i < count($kode_akun3); $i++) { 
            $data2[] = [
                'id_transaksi' => $id_transaksi,
                'kode_akun3' => $kode_akun3[$i],
                'debit' => $debit[$i],
                'kredit' => $kredit[$i],
                'id_status' => $id_status[$i],
            ];
            
        }

        $this->objNilai->insertBatch($data2);
        return redirect()->to(site_url('transaksi'))->with('success','Data Berhasil di Simpan');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $transaksi = $this->objtransaksi->find($id);
        $akun3= $this->objAkun3->findAll();
        $status = $this->objStatus->findAll();
        $nilai = $this->objNilai->findAll();
        $data ['dtnilai'] = $nilai;

        if(is_object($transaksi)){
            $data['dtakun3'] = $akun3;
            $data['dtstatus'] = $status;
            $data['dttransaksi'] = $transaksi;

                return view('transaksi/edit', $data);
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data1=[
            'tanggal' =>$this->request->getVar('tanggal'),
            'deskripsi' =>$this->request->getVar('deskripsi'),
            'ketjurnal' =>$this->request->getVar('ketjurnal'),
        ];

        $this->db->table('tbl_transaksi')->where(['id_transaksi' => $id ])->update($data1);

        $ids = $this->request->getVar('id_nilai');
        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debit = $this->request->getVar('debit');
        $kredit = $this->request->getVar('kredit');
        $id_status = $this->request->getVar('id_status');

        foreach ($ids as $key => $value) {
            $result[]=[
                'id_nilai' => $ids[$key],
                'kode_akun3' => $kode_akun3[$key],
                'debit' => $debit[$key],
                'kredit' => $kredit[$key],
                'id_status' => $id_status[$key],
            ];
        }
        $this->objNilai->updateBatch($result, 'id_nilai');
        return redirect()->to(site_url('transaksi'))->with('success','Data Berhasil di Update');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->db->table('tbl_transaksi')->where(['id_transaksi' => $id])->delete();
        return redirect()->to(site_url('transaksi'))->with('success','Data Berhasil di Delete');
    }

    public function akun3(){
        $akun3 = model(ModelAkun3::class);
        $result = $akun3->findAll();
        return $this->response->setJSON($result);
    }

    public function status(){
        $status = model(ModelStatus::class);
        $result = $status->findAll();
        return $this->response->setJSON($result);
    }
}
