<?php
require_once('lib/nusoap.php');

$url = "./soap/server.php?wsdl";
$client = new nusoap_client($url);

$err = $client->getError();

if ($err) {
    echo '<p><b>Error: ' . $err . '</b></p>';
}

$return = $client->call('procesaNotificacionSIS', "<Message><Request Ds_Version='0.0'>
        <Fecha>01/04/2011</Fecha>
        <Hora>16:57</Hora>
        <Ds_SecurePayment>1</Ds_SecurePayment>
        <Ds_Amount>345</Ds_Amount>
        <Ds_Currency>978</Ds_Currency>
        <Ds_Order>165446</Ds_Order>
        <Ds_MerchantCode>123456</Ds_MerchantCode>
        <Ds_Terminal>001</Ds_Terminal>
        <Ds_Card_Country>724</Ds_Card_Country>
        <Ds_Response>0000</Ds_Response>
        <Ds_MerchantData>Alfombrilla para raton</Ds_MerchantData>
        <Ds_Card_Type>C</Ds_Card_Type>
        <Ds_TransactionType>1</Ds_TransactionType>
        <Ds_ConsumerLanguage>1</Ds_ConsumerLanguage>
    </Request>
</Message>");

echo $return;
?>
