#!/usr/bin/env php
<?php
/**
 * 爬虫测试
 * php TestCrawler.php
 * @author Gene <https://github.com/Talkyunyun>
 */

require_once __DIR__ . '/vendor/owner888/phpspider/autoloader.php';

/* Do NOT delete this comment */
/* 不要删除这段注释 */

use phpspider\core\phpspider;
use phpspider\core\log;
use phpspider\core\requests;


$config = [
    'name' => '测试-任务',
//    'log_show' => true,
    'domains' => [
        'www.mafengwo.cn'
    ],
    'scan_urls' => [
        "http://www.mafengwo.cn/travel-scenic-spot/mafengwo/10088.html",
    ],
    'list_url_regexes' => [
        "http://www.mafengwo.cn/mdd/base/list/pagedata_citylist\?page=\d+",         // 城市列表页
        "http://www.mafengwo.cn/gonglve/ajax.php\?act=get_travellist\&mddid=\d+",   // 文章列表页
    ],
    'content_url_regexes' => [
        "http://www.mafengwo.cn/i/\d+.html"
    ],
    'export' => [
        'type' => 'csv',
        'file' => './crawler.csv',
    ],
    'fields' => [
        [
            'name'     => "title",
            'selector' => "//h1[contains(@class,'headtext')]",
            'required' => true,
        ],
        [
            'name' => "city",
            'selector' => "//div[contains(@class,'relation_mdd')]//a",
            'required' => true,
        ]
    ]
];

$spider = new phpspider($config);


// 初始化
$spider->on_start = function($phpspider) {
    requests::set_header('Referer','http://www.mafengwo.cn/mdd/citylist/21536.html');
};

/**
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据
 * @param $page
 * @param $content
 * @param $phpspider
 */
$spider->on_scan_page = function($page, $content, $phpspider) {
    //for ($i = 0; $i < 298; $i++)
    //测试的时候先采集一个国家，要不然等的时间太长
    for ($i = 0; $i < 1; $i++) {// 全国热点城市
        $url = "http://www.mafengwo.cn/mdd/base/list/pagedata_citylist?page={$i}";
        $options = [
            'method' => 'post',
            'params' => [
                'mddid' => 21536,
                'page'  => $i,
            ]
        ];

        $phpspider->add_url($url, $options);
    }
};


/**
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据
 * @param $page
 * @param $content
 * @param $phpspider
 */
$spider->on_list_page = function($page, $content, $phpspider) {
    // 如果是城市列表页
    if (preg_match("#pagedata_citylist#", $page['request']['url'])) {
        $data = json_decode($content, true);
        $html = $data['list'];
        preg_match_all('#<a href="/travel-scenic-spot/mafengwo/(.*?).html"#', $html, $out);
        if (!empty($out[1])) {
            foreach ($out[1] as $v) {
                $url = "http://www.mafengwo.cn/gonglve/ajax.php?act=get_travellist&mddid={$v}";
                $options = [
                    'method' => 'post',
                    'params' => [
                        'mddid' => $v,
                        'pageid'=> 'mdd_index',
                        'sort'  => 1,
                        'cost'  => 0,
                        'days'  => 0,
                        'month' => 0,
                        'tagid' => 0,
                        'page'  => 1
                    ]
                ];

                $phpspider->add_url($url, $options);
            }
        }
    } else {// 如果是文章列表页
        $data = json_decode($content, true);
        $html = $data['list'];
        // 遇到第一页的时候，获取分页数，把其他分页全部入队列
        if ($page['request']['params']['page'] == 1) {
            $data_page = trim($data['page']);
            if (!empty($data_page)) {
                preg_match('#<span class="count">共<span>(.*?)</span>页#', $data_page, $out);
                for ($i = 0; $i < $out[1]; $i++) {
                    $v = $page['request']['params']['mddid'];
                    $url = "http://www.mafengwo.cn/gonglve/ajax.php?act=get_travellist&mddid={$v}&page={$i}";
                    $options = [
                        'method' => 'post',
                        'params' => [
                            'mddid' => $v,
                            'pageid'=> 'mdd_index',
                            'sort'  => 1,
                            'cost'  => 0,
                            'days'  => 0,
                            'month' => 0,
                            'tagid' => 0,
                            'page'  => $i
                        ]
                    ];
                    $phpspider->add_url($url, $options);
                }
            }
        }

        // 获取内容页
        preg_match_all('#<a href="/i/(.*?).html" target="_blank">#', $html, $out);
        if (!empty($out[1])) {
            foreach ($out[1] as $v) {
                $url = "http://www.mafengwo.cn/i/{$v}.html";
                $phpspider->add_url($url);
            }
        }
    }
};

/**
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据
 * @param $page
 * @param $content
 * @param $phpspider
 */
//$spider->on_content_page = function($page, $content, $phpspider) {
//
//};


/**
 * 当一个field的内容被抽取到后进行的回调, 在此回调中可以对网页中抽取的内容作进一步处理
 * @param $fieldName
 * @param $data
 * @param $page
 */
$spider->on_extract_field = function($fieldName, $data, $page) {

    if ($fieldname == 'date') {
        $data = trim(str_replace(array("出发时间","/"),"", strip_tags($data)));
    }

    return $data;
};

/**
 * 在一个网页的所有field抽取完成之后, 可能需要对field进一步处理, 以发布到自己的网站
 * @param $page
 * @param $data
 */
$spider->on_extract_page = function($page, $data) {

    return $data;
};


// 运行
$spider->start();