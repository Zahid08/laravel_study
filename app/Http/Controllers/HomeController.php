<?php

namespace App\Http\Controllers;

use App\Contracts\ReportServiceInterface;

class HomeController extends Controller
{

    public function __construct(private ReportServiceInterface $reportService) {}

    public function index(){
        return $this->reportService->getReports();
    }
}
