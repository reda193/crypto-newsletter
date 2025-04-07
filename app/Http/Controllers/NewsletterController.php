<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function showSignupForm()
    {
        return view('newsletter.signup');
    }

    public function processSignup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:subscribers,email',
            'frequency' => 'required|in:minute,hour,daily',
            'percentage_alert' => 'required|numeric|min:1'
        ]);

        $subscriber = new Subscriber();
        $subscriber->name = $validated['name'];
        $subscriber->email = $validated['email'];
        $subscriber->frequency = $validated['frequency'];
        $subscriber->btc = $request->has('btc');
        $subscriber->eth = $request->has('eth');
        $subscriber->doge = $request->has('doge');
        $subscriber->xrp = $request->has('xrp');
        $subscriber->ltc = $request->has('ltc');
        $subscriber->sol = $request->has('sol');
        $subscriber->ada = $request->has('ada');
        $subscriber->avax = $request->has('avax');
        $subscriber->dot = $request->has('dot');
        $subscriber->matic = $request->has('matic');
        $subscriber->percentage_alert = $validated['percentage_alert'];
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
        
        if ($subscriber) {
            $name = $subscriber->name;
            $subscriber->delete();
            
            return view('newsletter.unsubscribe', ['name' => $name, 'email' => $email]);
        }
        
        return redirect('/signup');
    }
}