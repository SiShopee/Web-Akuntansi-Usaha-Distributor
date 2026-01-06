<?php

namespace App\Controllers;

use App\Models\EmployeeModel; // Panggil model karyawan yang kita buat di awal

class Karyawan extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Karyawan',
            'employees' => $this->employeeModel->findAll()
        ];

        return view('karyawan/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Karyawan'];
        return view('karyawan/create', $data);
    }

    public function store()
    {
        // Simpan data karyawan baru
        $this->employeeModel->save([
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'posisi'       => $this->request->getPost('posisi'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'gaji_pokok'   => $this->request->getPost('gaji_pokok'),
            'tunjangan'    => $this->request->getPost('tunjangan'),
        ]);

        return redirect()->to('/karyawan')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $this->employeeModel->delete($id);
        return redirect()->to('/karyawan')->with('success', 'Data karyawan dihapus.');
    }
}