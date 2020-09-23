<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Portfolio;

class Investment extends Model
{
    //

    protected $guarded = [];

    public function portfolio() {
        return $this->belongsTo('App\Portfolio');
    }

    public function addToInvestment($args) {
        $investment = Investment::where('user_id', $args['user_id'])->where('asset_id', $args['asset_id'])->first();
        $port = Portfolio::where('user_id', $args['user_id'])->first();
        $asset = Asset::find($args['asset_id']);
        
        $value_invested = ($investment->amount_of_asset * $investment->average_cost) + $args['value'];

        $amount_of_asset = $investment->amount_of_asset + $args['amount_of_asset'];

        $total_value = $investment->value  + ($args['amount_of_asset'] * $asset->current_price);

        $gain = $total_value - $value_invested;
        $percent_gain = ($gain / $value_invested) * 100;
        
      
        $new_args = [
        'value' => $total_value,
        'average_cost' => $value_invested / $amount_of_asset,
        'amount_of_asset' => $amount_of_asset,
        'investment_cost' => $value_invested,
        'gain' => $gain,
        'percent_gain' => $percent_gain
        ];

        $investment->fill($new_args);
        $investment->save();
    }

    public function editInvestment($oldData, $args)
    {
        $investment = Investment::where('user_id', $args['user_id'])->where('asset_id', $args['asset_id'])->first();
        $port = Portfolio::where('user_id', $args['user_id'])->first();
        $asset = Asset::find($args['asset_id']);
        
        
        // Pass in user ID from transaction Controller //

        // Get old investment

        // remove amount_of_asset and value passed in from $oldArgs (data of investment before updating)

        // Run through the process below which basically is like adding an entirely new transaction (but its not because transaction id
        // wont be changed and its not creating a new row in the DB)
        
        
        
        $value_invested = ($investment->amount_of_asset * $investment->average_cost) + $args['value'];
        $amount_of_asset = $investment->amount_of_asset + $args['amount_of_asset'];
        $total_value = $investment->value  + ($args['amount_of_asset'] * $asset->current_price);

        $gain = $total_value - $value_invested;
        $percent_gain = ($gain / $value_invested) * 100;
        
      
        $new_args = [
        'value' => $total_value,
        'average_cost' => $value_invested / $amount_of_asset,
        'amount_of_asset' => $amount_of_asset,
        'investment_cost' => $value_invested,
        'gain' => $gain,
        'percent_gain' => $percent_gain
        ];
    }
}
