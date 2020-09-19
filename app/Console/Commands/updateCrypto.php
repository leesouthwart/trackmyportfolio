<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Asset;
use App\Investment;
use App\Portfolio;

use AlphaVantage;

class updateCrypto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateprice:crypto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the prices of crypto currency assets';

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
        $assets = Asset::where('is_crypto', 1);

        // Loop through assets
        foreach ($assets as $asset) {
            
                $ASSET_OBJ = $client->foreignExchange()->currencyExchangeRate($asset->ticker_symbol, 'GBP');
                $price = $ASSET_OBJ['Realtime Currency Exchange Rate']['9. Ask Price'];
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
                }
            }
            

        
            //Get all investments where id match asset id
        return 0;
    }
}
