<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\ImageHelper;
use App\Helpers\Report;
use App\Http\Controllers\Controller;
use App\Models\Report as ModelsReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'des' => 'nullable|string',
            'image' => 'nullable|string',
        ]);




        $report = ModelsReport::create(['user_id' => Auth::id()] + $request->all());

        return Api::setResponse('report', $report);
    }
}
