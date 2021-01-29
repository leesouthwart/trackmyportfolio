@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
    
    @if(isset($port))   
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $port->title }}</div>

                <div class="card-body">

                    <p>Portfolio Amount: {{$port->amount}}</p>
                    <p>Portfolio Percentage Gain: {{$port->percent_gain}}%</p>
                    <p>Portfolio Gain: {{$port->gain}}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Investment</div>

                <div class="card-body">

                    <form method="post" action="/home/addTransaction">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <select type="number" name="asset_id">
                            @foreach($assets as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>

                        <input type="decimal" name="cost">
                        <label for="cost">Cost per Asset</label>

                        <input type="number" name="value">
                        <label for="value">Value of investment</label>

                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
