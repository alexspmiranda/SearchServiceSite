<?php

require_once ('mercadopago.php');

//pegue suas credenciais no link https://www.mercadopago.com/mlb/account/credentials

$mp = new MP('APP_USR-2861389320116788-091017-d79b5003b8de969db7ddea6124c763e6__LB_LC__-146782585'); //insira aqui o access token


$payment_data = array(
	"transaction_amount" => 50,
	"description" => "Title of what you are paying for",
	"payment_method_id" => "bolbradesco",
	"payer" => array (
		"email" => "test_user_19653727@testuser.com"
	)
);


// $payment_data = array(
//     "transaction_amount"   => 100, //valor da compra
//     "token"                => $_POST['token'], //token gerado pelo javascript da index.php
//     "description"          => "Title of what you are paying for", //descrição da compra
//     "installments"         => intval($_POST['installments']), //parcelas
//     "payment_method_id"    => $_POST['paymentMethodId'], //forma de pagamento (visa, master, amex...)
//     "payer"                => array ("email" => "test@testuser.com"), //e-mail do comprador
//     "statement_descriptor" => "SUA EMPRESA" //nome para aparecer na fatura do cartão do cliente
// );

$payment = $mp->post("/v1/payments", $payment_data);

echo "<pre>";
print_r($payment);

?>