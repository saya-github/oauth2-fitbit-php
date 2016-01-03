<?php

// アプリケーション設定
define('CONSUMER_KEY', 'Client_ID');
define('CONSUMER_SECRET', 'コンシューマーシークレット');
define('CALLBACK_URL', 'リダイレクトURL（登録済み）');

define('TOKEN_URL', 'https://api.fitbit.com/oauth2/token');


// アクセストークンの取得
$params = array(
	'client_id' => CONSUMER_KEY,
	'grant_type' => 'authorization_code',
	'redirect_uri' => CALLBACK_URL,
	'code' => $_GET['code'],
);

$header = [
	'Authorization: Basic ' . base64_encode(CONSUMER_KEY.':'.CONSUMER_SECRET),
	'Content-Type: application/x-www-form-urlencoded',
];

// POST送信
$options = array(
	'http' => array(
		'method' => 'POST',
		'header' => implode(PHP_EOL,$header),
		'content' => http_build_query($params),
		'ignore_errors' => true
		)
	);

$context = stream_context_create($options);

$res = file_get_contents(TOKEN_URL, false, $context);

// レスポンス取得
$token = json_decode($res, true);
if(isset($token['error'])){
	echo 'エラー発生';
	exit;
}

//　レスポンスからアクセストークンとユーザIDを取得
$access_token = $token['access_token'];
$user_id = $token['user_id'];

// 今日の心拍数を取得してみる（activities/heart）
$params = array('access_token' => $access_token);

$api_url = 'https://api.fitbit.com/1/user/' . $user_id . '/activities/heart/date/today/1d.json';

$header = 'Authorization: Bearer ' . $access_token;
$options = array(
	'http' => array(
		'method' => 'GET',
		'header' => $header,
		'ignore_errors' => true
		)
	);
$context = stream_context_create($options);

$res = file_get_contents($api_url, false, $context);

$heatrate = json_decode($res, true);
var_dump($heatrate);