<?php

	// アプリケーション設定
	define('CONSUMER_KEY', 'Client_ID');
	define('CALLBACK_URL', 'リダイレクトURL（登録済み）');

	// URL
	define('AUTH_URL', 'https://www.fitbit.com/oauth2/authorize');


	// 認証ページにリダイレクト
	$params = array(
		'client_id' => CONSUMER_KEY,
		'redirect_uri' => CALLBACK_URL,
		'scope' => 'heartrate',
		'response_type' => 'code',
	);

	header("Location: " . AUTH_URL . '?' . http_build_query($params));