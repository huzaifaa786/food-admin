<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\RestaurantFee;
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

    public function createPaymentIntent(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $restaurant = Restraunt::findOrFail($request->restaurant_id);

            $amount = $request->amount * 100;
            $fee = RestaurantFee::first();
            $serviceCharges = $fee ? $fee->service_charges : 0;
            $commission = $fee ? $fee->commission_percentage : 0;
            $applicationFee = $commission  + $serviceCharges;


            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'aed',
                'application_fee_amount' => $applicationFee * 100,
                'payment_method_types' => ['card'],
                'transfer_data' => [
                    'destination' => $restaurant->stripe_account_id,
                ],
                'on_behalf_of' => $restaurant->stripe_account_id,

            ]);

            return Api::setResponse('data', [
                'client_secret' => $intent->client_secret,
                'payment_intent_id' => $intent->id,
            ]);
        } catch (\Exception $e) {
            return Api::setError('This restaurant is unable to process payments at the moment.');
        }
    }
}
