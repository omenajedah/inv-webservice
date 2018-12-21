<?php

class trx_trans extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "trx_trans";
	}


	function putData($parameter) {
		$this->db->beginTransaction();
		$trx_cart = $this->load->model('trx_cart');
		$cart = $trx_cart->getData(null)->DataRow;

		if (!$cart)
			return array('success'=>false, 'reason'=>"Cart is empty!");

		$param = array('fields'=>'COUNT(N_TRX_ID) as RowCount', 'table'=>$this->TableName);
		$incrementor = 1;

		$lastId = 'TRX/'.date('Ymd').'/'.(parent::getTable((object)$param)['RowCount']+$incrementor);

		$parameter->N_TRX_ID = $lastId;
		$result = parent::putData($parameter);
		if ($result->success) {

			$lastSeller = '';

			$detil = $this->load->model('trx_trans_detail');
			$history = $this->load->model('trx_stock_history');
			$stockProduct = $this->load->model('mst_stock_product');
			$mst_price = $this->load->model('mst_price');
			$mst_user = $this->load->model('mst_user');

			foreach ($cart as $key => $value) {

				$param = array('Fields'=>'N_PRICE','N_ITENO'=>$value->N_ITENO, 'C_STATUS'=>1, 'C_TYPE'=>1);
				$price = $mst_price->getData((object)$param)->DataRow[0]->N_PRICE;
				$param = array('Fields'=>'N_SALDO','C_USERNAME'=>$_SESSION['C_USERNAME']);
				$saldo = $mst_user->getData((object)$param)->DataRow[0]->N_SALDO;
				$seller = $this->getTable((object) array('table'=>'mst_product','fields'=>'C_SELLER_ID', 'criteria'=>'N_ITENO = '.$value->N_ITENO))['C_SELLER_ID'];

				if ($price>$saldo) {
					$this->db->rollbackTransaction();
					return array('success'=>false, 'reason'=>'Your balance is not enough');
				}


				if ($lastSeller != '' && $seller != $lastSeller) {
					$incrementor++;

					$lastId = 'TRX/'.date('Ymd').'/'.(parent::getTable((object)$param)['RowCount']+$incrementor);

					$parameter->N_TRX_ID = $lastId;
					$result = parent::putData($parameter);
					if (!$result->success) {
						$this->db->rollbackTransaction();
						return array('success'=>false, 'reason'=>'trx error');
					}
				}

				$lastSeller = $seller;

				$value->N_TRX_ID = $lastId;
				$value->N_QTY = $value->N_BOOK;
				$value->N_TOTAL = $value->N_QTY * $price;
				$res = $detil->putData($value);
				if (!$res->success) {
					$this->db->rollbackTransaction();
					return array('success'=>false, 'reason'=>'detil error');
				}

				$param = array('C_USERNAME'=>$_SESSION['C_USERNAME'], 'N_SALDO'=>$saldo-$price);
				$res = $mst_user->putData((object)$param);
				if (!$res->success) {
					$this->db->rollbackTransaction();
					return array('success'=>false, 'reason'=>'Balance Error.');
				}


				$value->N_QOH_OLD = $value->N_QOH;
				$value->N_QOH = $value->N_QOH_OLD - $value->N_QTY;
				$value->C_USERNAME = $_SESSION['C_USERNAME'];

				$res = $history->putData($value);
				if (!$res->success) {
					$this->db->rollbackTransaction();
					return array('success'=>false, 'reason'=>'history error');
				}

				$res = $stockProduct->putData($value);
				if (!$res->success) {
					$this->db->rollbackTransaction();
					return array('success'=>false, 'reason'=>'stock error');
				}

				$res = $trx_cart->deleteData($value);
				if (!$res['success']) {
					$this->db->rollbackTransaction();
					return array('success'=>false, 'reason'=>'cart error');
				}

			}
		}
		$this->db->commitTransaction();

		return $result;
	}


}