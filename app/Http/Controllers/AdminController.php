<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class AdminController extends Controller
{ 
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        return view('dashboard.index', $this->adminService->getDashboardData());
    }

    public function doctorIndex(Request $request)
    {
        $data = $this->adminService->getDoctorDashboardData($request);
        return view('dashboard.doctor-index', $data);
    }
 
    public function nurseIndex(Request $request)
    {
        $data = $this->adminService->getNurseDashboardData($request);
        return view('dashboard.nurse-index', $data);
    }

    public function pharmacistIndex(Request $request)
    {
        $data = $this->adminService->getPharmacistDashboardData($request);
        return view('dashboard.pharmacist-index', $data);
    }

    public function laboratoryIndex(Request $request)
    {
        $data = $this->adminService->getLaboratoryDashboardData($request);
        return view('dashboard.laboratory-dashboard', $data);
    }

    public function receptionistIndex()
    {
        return view('dashboard.receptionist-index', $this->adminService->getDashboardData());
    }

}