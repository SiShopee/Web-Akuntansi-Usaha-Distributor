<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\EmployeeModel;

class Absensi extends BaseController
{
    protected $attendanceModel;
    protected $employeeModel;

    public function __construct()
    {
        $this->attendanceModel = new AttendanceModel();
        $this->employeeModel = new EmployeeModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Data Absensi',
            'attendance' => $this->attendanceModel->getAttendanceWithNames()
        ];
        return view('absensi/index', $data);
    }

    public function create()
    {
        $data = [
            'title'     => 'Input Absensi',
            'employees' => $this->employeeModel->findAll() // Kita butuh daftar nama buat dipilih
        ];
        return view('absensi/create', $data);
    }

    public function store()
    {
        $this->attendanceModel->save([
            'employee_id' => $this->request->getPost('employee_id'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'status'      => $this->request->getPost('status'),
            'jam_masuk'   => $this->request->getPost('jam_masuk'),
            'jam_keluar'  => $this->request->getPost('jam_keluar'),
        ]);

        return redirect()->to('/absensi')->with('success', 'Data absensi berhasil disimpan.');
    }
}