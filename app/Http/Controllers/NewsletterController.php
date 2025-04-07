<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\UnsubscribeConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
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
    /**
 * Process direct unsubscribe link from email
 */
public function unsubscribe($email)
{
    $email = urldecode($email);
    $result = $this->processUnsubscribeAndSendConfirmation($email);
    
    return view('newsletter.unsubscribe', $result);
}
    
    /**
     * Show the form for unsubscribing from the newsletter.
     */
    public function showUnsubscribeForm()
    {
        return view('newsletter.unsubscribe-form');
    }
    
 /**
 * Process unsubscribe form submission
 */
public function processUnsubscribe(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    
    $email = $request->email;
    $result = $this->processUnsubscribeAndSendConfirmation($email);
    
    if (!$result['success']) {
        return back()->withErrors(['email' => 'This email address is not subscribed to our newsletter.']);
    }
    
    return view('newsletter.unsubscribe', $result);
}

    /**
 * Send unsubscribe confirmation and process the unsubscribe request
 */
private function processUnsubscribeAndSendConfirmation($email)
{
    $subscriber = Subscriber::where('email', $email)->first();
    
    if (!$subscriber) {
        return [
            'success' => false,
            'message' => 'Email address not found in our subscriber list.'
        ];
    }
    
    $name = $subscriber->name;
    
    // Delete subscriber first to ensure they don't receive any more newsletters
    $subscriber->delete();
    
    // Send confirmation email
    try {
        Mail::to($email)->send(new UnsubscribeConfirmation($name, $email));
    } catch (\Exception $e) {
        // Log the error but don't stop the unsubscribe process
        Log::error("Failed to send unsubscribe confirmation: " . $e->getMessage());
    }
    
    return [
        'success' => true,
        'name' => $name,
        'email' => $email
    ];
}

}