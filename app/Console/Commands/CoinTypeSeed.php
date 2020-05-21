<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CoinTypeSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:seed_coin_type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        $this->info("填充cointype");
        $data = [
            [
                'coin_name' => 'btc',
                'alias' => '比特币',
                'sort' => 0
            ],
            [
                'coin_name' => 'eth',
                'alias' => '以太坊',
                'sort' => 0
            ],
            [
                'coin_name' => 'xrp',
                'alias' => 'xrp',
                'sort' => 1
            ],
            [
                'coin_name' => 'bch',
                'alias' => 'bth',
                'sort' => 0
            ],
            [
                'coin_name' => 'eos',
                'alias' => 'eos',
                'sort' => 10
            ],
            [
                'coin_name' => 'etc',
                'alias' => 'etc',
                'sort' => 0
            ],
            [
                'coin_name' => 'ht',
                'alias' => 'ht',
                'sort' => 5
            ],
            [
                'coin_name' => 'ltc',
                'alias' => '莱特币',
                'sort' => 5
            ],
            [
                'coin_name' => 'usdt',
                'alias' => 'usdt',
                'sort' => 5
            ],
            [
                'coin_name' => 'bsv',
                'alias' => 'bsv',
                'sort' => 5
            ]

        ];
        $res1 = \DB::table('coin_type')->truncate();
        $res2 = \DB::table('coin_type')->insert($data);

        if(  $res2){
            $this->info('币种插入成功');
        }else{

            $this->info('币种插入失败');
        }
    }
}
