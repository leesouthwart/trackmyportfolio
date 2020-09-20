@extends('layouts.app')

@section('content')

    <h1>Investment History Page</h1>
    
    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Asset</th>
                <th scope="col">Amount</th>
                <th scope="col">Cost</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody class="investment-table">
            @php $count = 1; @endphp
            @foreach ($transactions as $transaction)
            
                <tr>
                    <th scope="row">{{$count}}</th>
                    <td>{{$transaction->asset_name}}</td>
                    <td>{{(float)$transaction->amount_of_asset}}</td>
                    <td>{{$transaction->cost}}</td>
                    <td>{{$transaction->created_at->format('d-m-Y')}}</td>
                    <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transactionModal" data-edit={{@$transaction->id}}>Edit</button></td>
                </tr>
                @php $count++ @endphp
             @endforeach
        </tbody>
    </table>
    @include('partials.transaction-edit-modal')
@endsection


