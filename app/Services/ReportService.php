<?php

namespace App\Services;

use App\Contracts\ReportServiceInterface;

class ReportService implements ReportServiceInterface
{
    public function getReports(): string
    {
        return "Report data here";
    }
}
