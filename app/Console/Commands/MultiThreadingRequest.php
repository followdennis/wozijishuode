<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;

class MultiThreadingRequest extends Command
{
    private $totalPageCount;
    private $counter        = 1;
    private $concurrency    = 7;  // 同时并发抓取

    private $users = ['CycloneAxe', 'appleboy', 'Aufree', 'lifesign',
        'overtrue', 'zhengjinghua', 'NauxLiu'];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'multithread:exec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'multithread start execute';

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
//        $this->totalPageCount = count($this->users);
//
//        $client = new Client();
//
//        $requests = function ($total) use ($client) {
//            foreach ($this->users as $key => $user) {
//
//                $uri = 'https://api.github.com/users/' . $user;
//                yield function() use ($client, $uri) {
//                    return $client->getAsync($uri);
//                };
//            }
//        };
//
//        $pool = new Pool($client, $requests($this->totalPageCount), [
//            'concurrency' => $this->concurrency,
//            'fulfilled'   => function ($response, $index){
//
//                $res = json_decode($response->getBody()->getContents());
//
//                $this->info("请求第 $index 个请求，用户 " . $this->users[$index] . " 的 Github ID 为：" .$res->id);
//
//                $this->countedAndCheckEnded();
//            },
//            'rejected' => function ($reason, $index){
//                $this->error("rejected" );
//                $this->error("rejected reason: " . $reason );
//                $this->countedAndCheckEnded();
//            },
//        ]);
//
//        // 开始发送请求
//        $promise = $pool->promise();
//        $promise->wait();

        //第二个测试
        $client = new Client();
        $url = 'http://www.qulishi.com/';
        $http = $client->request('GET',$url);
        if ($http->getStatusCode() == 200) {
            // 判断 http 状态码为 200 的时候，执行成功
            // echo $http->getBody();
            echo $http->getBody()->getContents();
        }

    }

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount){
            $this->counter++;
            return;
        }
        $this->info("请求结束！");
    }

}
