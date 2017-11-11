<?php
use Workerman\Worker;
require_once __DIR__ . '/Autoloader.php';

// ����һ��Worker����2345�˿ڣ�ʹ��httpЭ��ͨѶ
$http_worker = new Worker("http://0.0.0.0:2345");

// ����4�����̶����ṩ����
$http_worker->count = 4;

// ���յ���������͵�����ʱ�ظ�hello world�������
$http_worker->onMessage = function($connection, $data)
{
    // �����������hello world
    $connection->send('hello world');
};

// ����worker
Worker::runAll();