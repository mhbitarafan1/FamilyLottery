<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lot;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Lottery;
use App\LotteryManager;


class runLotsThisTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runLotsThisTime:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do lottery hourly at 1 minute';

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
     * @return mixed
     */
    public function handle()
    {

    $onTimeLots = Lot::where('time_holding','<', now())->where('stock_winner','=',NULL)->get();
        
    foreach ($onTimeLots as $onTimeLot) {

        $lotteryOfThisLot = lottery::where('id',$onTimeLot->lottery_id)->first();
        if($lotteryOfThisLot->type_of_choose_winner=='سیستم'){

            if($lotteryOfThisLot->type_of_income=='firstlot' && $onTimeLot->number==1){
                if ($firstManagerStock = $lotteryOfThisLot->lotterystocks->where('owner',LotteryManager::find($lotteryOfThisLot->lottery_manager_id)->user_id)->first()) {
                    $firstManagerStock->update([
                                     'winned' => true,
                                ]);
                    
                    $onTimeLot->update([
                        'stock_winner' => $firstManagerStock->id,
                    ]);
                }


            }
            else {              
                
                $stocksDontWinned=$lotteryOfThisLot->lotterystocks->where('winned',0);
                foreach ($stocksDontWinned as $stockDontWinned) {
                   $paidInstallments = $stockDontWinned->installments->where('lot_id','<=',$onTimeLot->id)->where('paid',true);
                    
                    if(count($paidInstallments) >= $onTimeLot->number)
                   {
                    $inclodedStocksOnLotId[] =  $stockDontWinned->id;
                   }
                }
                if(isset($inclodedStocksOnLotId)){
                $winnerStockId = Arr::random($inclodedStocksOnLotId);
                $onTimeLot->update([
                    'stock_winner' => $winnerStockId,
                ]);
                $stockWinner = $lotteryOfThisLot->lotterystocks->where('id',$winnerStockId)->first();
                $stockWinner->update([
                    'winned' => true,
                ]);
                }

            }




        }




    }










        $this->info('the lots runned');
    }
}
