<?php

namespace App\Http\Controllers;

use App\Models\Restraunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
use Stripe\AccountLink;
use Stripe\OAuth;

class StripeController extends Controller
{
    public function connect($restaurantId)
    {
        $restaurant = Restraunt::find($restaurantId);

        $url = 'https://connect.stripe.com/oauth/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => config('services.stripe.client_id'),
            'scope' => 'read_write',
            'redirect_uri' => route('stripe.callback'),
            'state' => $restaurant->id,
        ]);

        $restaurant->stripe_onboard_url = $url;
        $restaurant->save();

        return redirect($url);
    }

    public function callback(Request $request)
    {

        $code = $request->get('code');
        $restaurantId = $request->get('state');

        $response = Http::asForm()->post('https://connect.stripe.com/oauth/token', [
            'client_secret' => config('services.stripe.secret'),
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);

        $stripeUserId = $response['stripe_user_id'];

        $restaurant = Restraunt::find($restaurantId);
        $restaurant->stripe_account_id = $stripeUserId;
        $restaurant->onboarding_status = 'completed';
        $restaurant->save();

        return redirect()->to('/stripe/onboarding-success'); // Redirect to success page
    }
}
