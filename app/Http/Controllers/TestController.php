<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use QL\QueryList;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

class TestController extends Controller
{
    //
    public function test($id){

        echo 'test3';
        echo $id;
    }
    public function spider(){
        $client = new Client();
        $requests = function ($total) {
            $uri = 'http://www.qulishi.com';
            for ($i = 0; $i < $total; $i++) {
                yield new Request('GET', $uri);
            }
        };
        $pool = new Pool($client, $requests(6), [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index) {
                // this is delivered each successful response
                if ($response->getStatusCode() == 200) {

                    // 判断 http 状态码为 200 的时候，执行成功
                    // echo $http->getBody();
                    $html =  $response->getBody()->getContents();
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($html);

//                    foreach ($crawler as $domElement) {
//                        echo "<br/>";
//                        var_dump($domElement->nodeName);
//                    }
//                    $crawler = $crawler->filter('body div')->eq(0)->text();
//                    $tag = $crawler->filterXPath('//body/*')->nodeName();
//                    $tag = $crawler->filterXPath('//body/div')->text();
//                    $tag = $crawler->filterXPath('//body/div')->attr('id');
//                    $attributes = $crawler
//                        ->filterXpath('//body/div')
//                        ->extract(array('_text', 'id'));
//                    $nodeValues = $crawler->filter('h2>a')
//                        ->each(function (Crawler $node, $i) {
//                        return $node->text();
//                    });
//                    $html = $crawler->html();
//                    echo $html;
//                    $link = $crawler->selectLink('http://www.qulishi.com/news/201707/231994.html')->link();
//
//                    echo  $link->getUri();

//                    $image = $crawler->selectImage('汉代因避讳吕雉之名用野鸡来代替')->image();
//                    dd($image);
//                       $converter =  new CssSelectorConverter();
//                        $xpath = $converter->toXPath('div.intro > a');
//                        echo $xpath;
//                        $title = $crawler->filterXPath($xpath)->text();
//                        print_r($title);
                        echo  '<br/>';
                    //采集规则
                    $rules = array(
                        //文章标题
                        'title' => ['dl.p3_r_2_list dd','text'],
                        //文章链接
                        'link' => ['dl.p3_r_2_list dd a','href'],

                    );
                    //列表选择器
                    $rang = '';
                    $data = QueryList::Query($html,$rules,$rang)->data;
                    echo "<pre>";
                    print_r($data);
                    echo "</pre>";

                }
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
            },
        ]);
        // Initiate the transfers and create a promise
        $promise = $pool->promise();
        // Force the pool of requests to complete.
        $promise->wait();
    }

    public function test2(){
        $res = DB::connection('mysql_center')->table('fanw8')->take('10')->get()->toArray();
        dd($res);
    }
    public function query_list(){

        $page = 'https://laravel-china.org/categories/6';
        //采集规则
        $rules = array(
            //文章标题
            'title' => ['.media-heading a','text'],
            //文章链接
            'link' => ['.media-heading a','href'],
            //文章作者名
            'author' => ['.img-thumbnail','alt']
        );
        //列表选择器
        $rang = '.topic-list>li';
        //采集
        $data = \QL\QueryList::Query($page,$rules,$rang)->data;
        //查看采集结果
        echo "<pre>";
        print_r($data);

    }
}
