<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\UnsubscribeConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * Class NewsletterController
 * @package App\Http\Controllers
 * 
 * This controller handles all newsletter subscription functionality,
 * including signup, unsubscribe, and success pages. It manages the
 * creation and deletion of subscriber records and sending confirmation
 * emails to users.
 */
class NewsletterController extends Controller
{
    /**
     * Display the newsletter signup form.
     *
     * @return \Illuminate\View\View
     */
    public function showSignupForm()
    {
        return view('newsletter.signup');
    }
    
    /**
     * Process the newsletter signup form submission.
     * 
     * Validates the form data, creates a new subscriber record,
     * and redirects to the success page.
     *
     * @param Request $request The HTTP request
     * @return \Illuminate\Http\RedirectResponse
     */
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
    
    /**
     * Display the signup success page.
     *
     * @return \Illuminate\View\View
     */
    public function showSuccess()
    {
        return view('newsletter.success');
    }
    
    /**
     * Process direct unsubscribe link from email.
     * 
     * Allows users to unsubscribe directly from a link in the newsletter.
     *
     * @param string $email The encoded email address
     * @return \Illuminate\View\View
     */
    public function unsubscribe($email)
    {
        $email = urldecode($email);
        $result = $this->processUnsubscribeAndSendConfirmation($email);
        
        return view('newsletter.unsubscribe', $result);
    }
    
    /**
     * Show the form for unsubscribing from the newsletter.
     *
     * @return \Illuminate\View\View
     */
    public function showUnsubscribeForm()
    {
        return view('newsletter.unsubscribe-form');
    }
    
    /**
     * Process unsubscribe form submission.
     * 
     * Validates the form data and processes the unsubscription request.
     *
     * @param Request $request The HTTP request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
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
     * Send unsubscribe confirmation and process the unsubscribe request.
     * 
     * Helper method to handle the unsubscription process and send
     * confirmation emails to users.
     *
     * @param string $email The email address to unsubscribe
     * @return array Result data including success status and messages
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