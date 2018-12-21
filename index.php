<?php

// print_r($_SERVER);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

ini_set("session.gc_maxlifetime", 1800);
// Set the session cookie to timout
ini_set("session.cookie_lifetime", 1800);

include('core/includes.php');
include('application/'.DEFAULT_CONTROLLER.'.php');
require_once 'lib/XmlRequest.php';
require_once 'lib/JsonRequest.php';
require_once 'lib/FormDataRequest.php';
require_once 'lib/FormUrlEncodedRequest.php';


$app = new mobile();
$app->addRequestHandler('application/xml', new XmlRequest);
$app->addRequestHandler('application/json', new JsonRequest);
$app->addRequestHandler('multipart/form-data', new FormDataRequest);
$app->addRequestHandler('application/x-www-form-urlencoded', new FormUrlEncodedRequest);

$app->post('/register', function($request) use($app) {
	if (!$request->body->user_name || !$request->body->user_pass) {
		return array('success'=>false, 'reason'=>'Masukkan data yang lengkap.');
	}
	$model = $app->load->model('tbl_user');
	$resultData = $model->getTable((object)array('fields'=>'user_name', 'criteria'=> "user_name = '{$request->body->user_name}'"));

	if ($resultData)
		return array('success'=>false, 'reason'=>'Username telah terdaftar, silahkan gunakan username lain.');

	return $model->putData($request->body);
});

$app->post('/login', function($request) use($app) {
	if (!isset($request->body->user_name) || !isset($request->body->user_pass)) {
		return array('success' => false, 'reason' => 'Username dan Password tidak boleh kosong.');
	}
	$model = $app->load->model('tbl_user');
	$retData = $model->getData($request->body);
	if (!$retData->RowCount) {
		return array('success' => false, 'reason' => 'Username atau Password salah.');
	}
	session_start();

	$_SESSION['user_name'] = $request->body->user_name;
	$_SESSION['user_pass'] = $request->body->user_pass;
	return array('success'=>true, 'profile'=>$retData->DataRow[0]);

});

$app->get('/usermanagement', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_user');
	$retData = $model->getData($request->body);

	return array('success'=>true, 'DataRow'=>$retData->DataRow);
});

$app->post('/usermanagement', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_user');
	$retData = $model->putData($request->body);

	return $retData;
});

$app->post('/barang', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_barang');
	$retData = $model->getData($request->body);

	return array('success'=>true, 'DataRow'=>$retData->DataRow);
});

$app->post('/barangmanagement', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_barang');
	$retData = $model->putData($request->body);

	return $retData;
});

$app->post('/barangmasuk', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_barang_masuk');
	$retData = $model->putData($request->body);

	return $retData;
});

$app->post('/barangkeluar', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_barang_keluar');
	$retData = $model->putData($request->body);

	return $retData;
});

$app->post('/laporan', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('trx_laporan');
	$retData = $model->getData($request->body);

	return $retData;
});


$app->post('/supplier', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_supplier');
	$retData = $model->getData($request->body);

	return $retData;
});

$app->post('/editsupplier', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_supplier');
	$retData = $model->putData($request->body);

	return $retData;
});


$app->post('/mandor', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_mandor');
	$retData = $model->getData($request->body);

	return $retData;
});

$app->post('/editmandor', function($request) use($app) {
	// session_start();
	// if (!$_SESSION['user_name'] || !$_SESSION['user_pass']) {
	// 	return array('success'=>false, 'reason'=>'Maaf, anda harus login dahulu.');
	// }
	$model = $app->load->model('tbl_mandor');
	$retData = $model->putData($request->body);

	return $retData;
});


$app->run();