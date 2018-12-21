<?php

$DefaultFields = " a.N_ITENO, a.V_ITNAM, a.C_IMAGE_PATH, b.N_PRICE, c.N_QOH, d.N_BOOK, d.V_NOTES, e.C_SELLER_NAME ";
$Where = " WHERE 1 ";
$order = " Order By a.N_ITENO ";

$C_USERNAME = $_SESSION['C_USERNAME'];

if ($Fields) {
	$DefaultFields = $Fields;
}

if (!$PRICE_TYPE) {
	$PRICE_TYPE = 1;
}

if ($N_ITENO) {
	$Where.=" AND a.N_ITENO = '{$N_ITENO}' ";
}

if ($OrderBy) {
	$order = " ORDER BY {$OrderBy}";
}


if ($Mode == "Regular") {
	$SQL = "SET @C_USERNAME = '{$C_USERNAME}';
			SET @PRICE_TYPE = '{$PRICE_TYPE}';

			SELECT $DefaultFields 
			FROM mst_product a
			JOIN mst_price b ON a.`N_ITENO` = b.`N_ITENO` AND b.`C_TYPE` = @PRICE_TYPE AND b.D_UPDATE < NOW() AND b.D_EXPIRED > NOW() AND b.`C_STATUS` = 1
			JOIN mst_stock_product c ON a.`N_ITENO` = c.`N_ITENO`
			JOIN trx_cart d ON a.`N_ITENO` = d.`N_ITENO` AND d.`C_USERNAME` = @C_USERNAME
			JOIN mst_seller e ON a.`C_SELLER_ID` = e.`C_SELLER_ID` ";

} else {
	$SQL = "SET @C_USERNAME = '{$C_USERNAME}';
			SET @PRICE_TYPE = '{$PRICE_TYPE}';

			SELECT COUNT(*) as rowCount
			FROM mst_product a 
			JOIN mst_price b ON a.`N_ITENO` = b.`N_ITENO` AND b.`C_TYPE` = @PRICE_TYPE AND b.D_UPDATE < NOW() AND b.D_EXPIRED > NOW() AND b.`C_STATUS` = 1
			JOIN mst_stock_product c ON a.`N_ITENO` = c.`N_ITENO`
			JOIN trx_cart d ON a.`N_ITENO` = d.`N_ITENO` AND d.`C_USERNAME` = @C_USERNAME
			JOIN mst_seller e ON a.`C_SELLER_ID` = e.`C_SELLER_ID` ";
}

$SQL.=$Where.=$order;

