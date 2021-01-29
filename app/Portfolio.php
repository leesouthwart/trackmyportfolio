<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Investment;

class Portfolio extends Model
{
    //
    public function investment() {
        return $this->hasMany('App\Investment');
    }

    public function updateHoldings(Portfolio $portfolio) {
        $investments = Investment::where('user_id', $portfolio->user_id)->get();

        $value = 0;
        $investment_cost = 0;

        foreach ($investments as $invest) {
            $value += $invest->value;
            $investment_cost += $invest->average_cost * $invest->amount_of_asset;
        }

        $gain = $value - $investment_cost;
        $portfolio->gain = $gain;
        $portfolio->percent_gain = ($gain / $investment_cost) * 100;

        $portfolio->value = $value;
        $portfolio->investment_cost = $investment_cost;
        $portfolio->save();
    }
}
