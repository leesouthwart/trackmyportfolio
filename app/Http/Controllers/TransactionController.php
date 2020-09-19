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
    public function store(Request $request) {

        $validatedData = $request->validate([
            'asset_id' => 'required',
            'cost' => 'required',
            'value' => 'required',
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
