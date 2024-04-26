<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\OrderStatus;
use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Method store
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function store(Request $request)
    {
        $rating = Rating::create([
            'user_id' => auth()->user()->id,
            'restraunt_id' => $request->restaurant_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'notes' => $request->notes
        ]);

        $order = Order::find($request->order_id);
        $order->update(['has_rating' => true]);

        return Api::setResponse('rating', $rating);
    }

    /**
     * Method checkRating
     *
     * @return void
     */
    public function checkRating()
    {
        $order = Order::where('user_id', auth()->user()->id)->where('status', OrderStatus::DELIVERED->value)->latest()
            ->first();
        if ($order) {
            if ($order->has_rating) {
                return Api::setError('rating already exists');
            } else {
                $order->restraunt;
                return Api::setResponse('order', $order);
            }
        } else {
            return Api::setError('no order found');
        }
    }
}
