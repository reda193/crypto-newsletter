@extends('layouts.app')

@section('title', 'Unsubscribed')

@section('heading', 'Unsubscribe Confirmation')

@section('content')
    <div class="unsubscribe-message">
        <p>You have been successfully unsubscribed from the newsletter.</p>
        
        @if(isset($name) && isset($email))
            <p>Email address <strong>{{ $email }}</strong> has been removed from our database.</p>
        @endif
        
        <p>Thank you for your past subscription.</p>
    </div>
@endsection