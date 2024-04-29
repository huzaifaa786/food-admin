<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Restraunt;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showTotalRestraunts()
    {
        $totalRestraunts = Restraunt::count();
        $totalUsers = User::count();
        $totalDrivers = Driver::count();

        return view('admin.dashboard.index', compact('totalRestraunts', 'totalUsers','totalDrivers'));
    }
}
