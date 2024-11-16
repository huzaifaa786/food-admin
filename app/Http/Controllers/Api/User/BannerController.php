<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\LocationHelper;
use App\Http\Controllers\Controller;
use App\Models\Poster;
use App\Models\Restraunt;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    // public function index()
    // {
    //     $posters = Poster::where('created_at', '>=', now()->subDay())->get();
    //     return Api::setResponse('posters', $posters);
    // }

    public function index()
    {
        $user = auth()->user();

        $address = UserAddress::where('user_id', $user->id)->first();

        $posters = Poster::where('created_at', '>=', now()->subDay())->get();

        $filteredPosters = collect();

        if ($address) {
            foreach ($posters as $poster) {
                $restaurant = Restraunt::find($poster->restraunt_id);

                if (!$restaurant) {
                    continue;
                }

                $distance = LocationHelper::calculateDistance($address->lat, $address->lng, $restaurant->lat, $restaurant->lng);

                if ($distance <= ($restaurant->radius * 1000)) {
                    $filteredPosters->push($poster);
                }
            }
        }

        if ($filteredPosters->isEmpty()) {
            return Api::setResponse('message', 'No posters available within your location range.');
        }

        return Api::setResponse('posters', $filteredPosters);
    }
}
