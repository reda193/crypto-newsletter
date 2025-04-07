<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function showSignupForm()
    {
        return view('newsletter.signup');
    }
    
    public function processSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:subscribers,email',
            'frequency' => 'required|in:minute,hour,daily',
            'percentage_alert' => 'required|numeric|min:0.1|max:100',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Create new subscriber
        $subscriber = new Subscriber();
        $subscriber->name = $request->name;
        $subscriber->email = $request->email;
        $subscriber->frequency = $request->frequency;
        $subscriber->percentage_alert = $request->percentage_alert;
        
        // Set crypto preferences
        $cryptos = ['btc', 'eth', 'doge', 'xrp', 'ltc', 'sol', 'ada', 'avax', 'dot', 'matic'];
        foreach ($cryptos as $crypto) {
            $subscriber->$crypto = $request->has($crypto) ? 1 : 0;
        }
        
        $subscriber->save();
        
        return redirect()->route('signup.success');
    }
    
    public function showSuccess()
    {
        return view('newsletter.success');
    }
    
    public function unsubscribe($email)
    {
        $email = urldecode($email);
        $subscriber = Subscriber::where('email', $email)->first();
        
        if (!$subscriber) {
            return view('newsletter.unsubscribe', [
                'success' => false,
                'message' => 'Email address not found in our subscriber list.'
            ]);
        }
        
        $name = $subscriber->name;
        $subscriber->delete();
        
        return view('newsletter.unsubscribe', [
            'success' => true,
            'name' => $name,
            'email' => $email
        ]);
    }
}