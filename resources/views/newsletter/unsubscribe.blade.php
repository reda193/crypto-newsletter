@extends('layouts.app')

@section('title', 'Unsubscribe')

@section('heading', 'Newsletter Unsubscribe')

@section('content')
    <div class="unsubscribe-container">
        @if($success)
            <div class="success-message">
                <h2>Successfully Unsubscribed</h2>
                <p>Hi {{ $name }},</p>
                <p>You have been successfully unsubscribed from our cryptocurrency newsletter.</p>
                <p>Your email address ({{ $email }}) has been removed from our mailing list.</p>
                <p>We're sorry to see you go. If you'd like to subscribe again in the future, please visit our <a href="{{ route('signup.form') }}">signup page</a>.</p>
            </div>
        @else
            <div class="error-message">
                <h2>Unsubscribe Failed</h2>
                <p>{{ $message }}</p>
                <p>If you're still having trouble unsubscribing, please contact our support team.</p>
            </div>
        @endif
    </div>
@endsection