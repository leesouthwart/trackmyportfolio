<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\Asset;
use App\Investment;
use App\Portfolio;

use AlphaVantage;

class updateStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateprice:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Stock asset prices via Alpha Vantage API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Start Client
        $option = new AlphaVantage\Options();
        $option->setApiKey(env('AV_KEY')); 
        $client = new AlphaVantage\Client($option);
        

        // Get all Assets
        $assets = Asset::where('is_crypto', 0)->get();
        
        $test = $client->TimeSeries()->daily('GB00BD3RZ582');
        console.log('test');
        // Loop through assets
        foreach ($assets as $asset) {
            
                $ASSET_OBJ = $client->TimeSeries()->daily($asset->ticker_symbol);
                $price = $ASSET_OBJ['Time Series (Daily)'];
                $price = $price[array_key_first($price)];
                $price = $price['4. close'];
                $asset->current_price = $price;
                $asset->save();
                print($asset->asset_name . ' updated, ');

                $investments = Investment::where('asset_id', $asset->id)->get();
                foreach ($investments as $inv) {
                    $counter = 0;
                    $inv->value = $inv->amount_of_asset * $price;

                    $inv->gain = $inv->value - $inv->investment_cost;
                    $inv->percent_gain = ($inv->gain / $inv->investment_cost) * 100;
                    $inv->save();
                    $counter++;
                    print($asset->name . ' Investment #' . $counter . ' updated.' . "\xA");

                    $portfolio = Portfolio::where('id', $inv->portfolio_id)->first();
                    print('portfolio found...');
                    $portfolio->updateHoldings($portfolio);
                    print(' portfolio updated' . "\xA");
                }
            } 
        return;
    }
}
