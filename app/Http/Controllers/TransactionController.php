<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Transaction;
use App\Investment;
use App\Portfolio;
use App\Asset;

class TransactionController extends Controller
{
    //
    
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)->get();
        $assets = Asset::pluck('asset_name', 'id')->toArray();

        return view('transactions', compact('transactions', 'assets'));
    }

    public function edit(Request $request)
    {  
        
       
        $vData = $request->validate([
            'asset_id' => 'required',
            'cost' => 'required',
            'value' => 'required',
            'id' => 'required',
            'user_id' => 'required',
        ]);

        $vData['amount_of_asset'] = $vData['value'] / $vData['cost'];
        $transaction = Transaction::where('id', $vData['id'])->first();
        $asset = Asset::where('id', $vData['asset_id'])->first();
        $oldData = $transaction;

        $investment = Investment::where('asset_id', $transaction->asset_id)->where('user_id', $transaction->user_id)->first();
        $investment->editInvestment($oldData, $vData);

        $transaction->asset_name = $asset->asset_name;
        $transaction->asset_id = $vData['asset_id'];
        
        $transaction->amount_of_asset = $vData['value'] / $vData['cost'];
        $transaction->cost = $vData['cost'];
        $transaction->value = $vData['value'];

        
        $transaction->save();

        


        $portfolio = Portfolio::where('user_id', $transaction->user_id)->first();
        $portfolio->updateHoldings($portfolio);


        return redirect('/history');
        
    }
    

    public function store(Request $request) {

        $validatedData = $request->validate([
            'asset_id' => 'required',
            'cost' => 'required',
            'value' => 'required',
            'user_id' => 'required'
        ]);

        $validatedData['amount_of_asset'] = $validatedData['value'] / $validatedData['cost'];
        $asset = Asset::find($request['asset_id']);
    
        $validatedData['asset_name'] = $asset['asset_name'];

        $transaction = new Transaction;
        $transaction->fill($validatedData);
        $transaction->save();

        // Need to pass as args [user_id, asset_id, asset_amount, value, average_cost, portfolio_id] to Investment->addToInvestment

        $args = $validatedData;
        $args['user_id'] = $request['user_id'];

        // Get Users portfolio
        $portfolio = Portfolio::where('user_id', $request['user_id'])->first();
        

        if(!$portfolio) {
            $portfolio = new Portfolio;
            $portfolio->user_id = $request['user_id'];
            $portfolio->title = "Default Portfolio";
            $portfolio->percent_gain = 0;
            $portfolio->gain = 0;
            $portfolio->investment_cost = 0;
            $portfolio->save();
        }

        $args['portfolio_id'] = $portfolio->id;
        
        // Get Investment model where user id and asset id match
        $investment = Investment::where('user_id', $request['user_id'])->where('asset_id', $validatedData['asset_id'])->first();

        if ($investment) {
            $investment->addToInvestment($args);
        } else {
            
            $investment = new Investment;
            $args['average_cost'] = $validatedData['cost'];
            unset($args['cost']);
            $args['value'] = $args['amount_of_asset'] * $asset->current_price;
            $args['investment_cost'] = $args['amount_of_asset'] * $args['average_cost'];
            $args['gain'] = $args['value'] - $args['investment_cost'];
            $args['percent_gain'] = ($args['gain'] / $args['investment_cost']) * 100;
            

            $investment->fill($args);
            $investment->save();
        }

        $portfolio->updateHoldings($portfolio);

        return redirect('/home');

        // In future -> write a check that sees if an asset_id exists. And if it does not, call a function that creates the asset, runs an api call to populate price data, etc.
    }
}
