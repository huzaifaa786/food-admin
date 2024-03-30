<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\Http\Request;

class PosterController extends Controller
{
    /**
     * Method addPoster
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function addPoster(Request $request)
    {
        $poster = Poster::create([
            'restraunt_id' => auth()->user()->id,
            'poster' => $request->poster
        ]);

        return Api::setResponse('poster', $poster);
    }
}
