<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Restraunt;
use Illuminate\Http\Request;

class RestrauntController extends Controller
{
    public function index()
    {
        $restaurants = Restraunt::all();
        return Api::setResponse('restaurants', $restaurants);
    }
}
