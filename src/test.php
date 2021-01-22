<?php

include '/data0/www/htdocs/temp/redis-bloom-filter/vendor/autoload.php';
include '/data0/www/htdocs/temp/redis-bloom-filter/src/BloomFilter.php';

use Mu\BloomFilter\BloomFilter;


# redis服务器
$redis_conf = [
    'host' => '127.0.0.1',
    'port' => 7006,
];
echo '链接redis成功，测试开始'."\n";
$bloomfilter = new BloomFilter($redis_conf);
# 设置评论的空间
$bloomfilter->set_bucket('black_ips');
# 添加一个ip
$ip     = '127.0.0.1';
$add_rs = $bloomfilter->add($ip);
# 批量添加
$ips     = ['192.168.0.1', '192.168.0.2'];
$adds_rs = $bloomfilter->multi_add($ips);

# 检查ip
$rs = $bloomfilter->exists($ip);
echo $ip.'存在结果'.json_encode($rs)."\n";

# 检查ip
$notExitIp = '192.168.0.3';
$notExistRs = $bloomfilter->exists($notExitIp);
echo $notExitIp.'存在结果'.json_encode($notExistRs)."\n";

# 批量检查ip
$multi_rs = $bloomfilter->multi_exists($ips);
echo json_encode($ips).'存在结果'.json_encode($multi_rs)."\n";

