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
      
        $new_args = [
        'value' => $total_value,
        'average_cost' => $value_invested / $amount_of_asset,
        'amount_of_asset' => $amount_of_asset
        ];

        $investment->fill($new_args);
        $investment->save();
    }
}
