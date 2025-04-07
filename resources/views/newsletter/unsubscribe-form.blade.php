@extends('layouts.app')

@section('title', 'Unsubscribe')

@section('heading', 'Newsletter Unsubscribe')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="container-card">
            <h2 class="form-title">Unsubscribe from Newsletter</h2>
            
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="post" action="{{ route('newsletter.unsubscribe.process') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    <div class="form-text">Enter the email address you used to subscribe.</div>
                </div>
                
                <div class="mb-3">
                    <button type="submit" class="btn btn-danger">Unsubscribe</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection