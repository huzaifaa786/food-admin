<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $posters = Poster::where('created_at', '>=', now()->subDay())->get();
        return Api::setResponse('posters', $posters);
    }
}
