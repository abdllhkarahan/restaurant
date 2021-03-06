<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Card;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;


class CardController extends Controller
{
    public function addToCard(Product $product)
    {
        if(session() -> has('card'))
        {
            $card = new Card(session() -> get('card'));
        } else
        {
            $card = new Card();
        }
        $card -> add($product);
        // dd($card);
        session() -> put('card', $card);
        notify() -> success('Product added to card!');
        return redirect() -> back();
    }

    public function showCard()
    {
        if(session() -> has('card'))
        {
            $card = new Card(session() -> get('card'));
        } else
        {
            $card = null;
        }
        return view('card', compact('card'));
    }

    public function updateCard(Request $request, Product $product)
    {
        $request->validate([
            'quantity'=>'required|numeric|min:1'
        ]);

        $card = new Card(session()->get('card'));

        $card -> updateQuantity($product -> id, $request -> quantity);
        session() -> put('card',$card);
        notify() -> success('Card updated!');
        return redirect() -> back();
    }

    public function destroyCard(Product $product)
    {
        $card = new Card(session() -> get('card'));
        $card -> destroy($product -> id);
        if($card -> totalQuantity <= 0)
        {
            session() -> forget('card');
        } else
        {
            session() -> put('card', $card);
        }
            notify() -> success('Product removed from card!');
            return redirect() -> back();
    }

    public function checkout($amount)
    {
        return view('checkout', compact('amount'));
    }

    public function charge(Request $request)
    {
        $charge = Stripe::charges() -> create(
            [
                'currency' => 'TRY',
                'source' => $request -> stripeToken,
                'amount' => $request -> amount,
                'description' => 'test',
            ]
        );
        $chargeId = $charge['id'];
        if($chargeId)
        {
            auth() -> user() -> orders() -> create(
                [
                    'card' => serialize(session() -> get('card'))
                ]
            );
            session() -> forget('card');
            notify() -> success('Payment completed!');
            return redirect() -> to('/');
        } else
        {
            return redirect() -> back();
        }
        // return $request -> stripeToken;
    }


}
