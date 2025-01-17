<?php

use PayPal\Api\Webhook;
// # Delete Webhook Sample
//
// This sample code demonstrate how to use this call to search for all webhook events., as documented here at:
// https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_delete
// API used: DELETE v1/notifications/webhooks/{webhook_id}
// ## Get Webhook Instance
/** @var Webhook $webhook */
$webhook = require 'CreateWebhook.php';


// ### Delete Webhook
try {
    $output = $webhook->delete($apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("Delete a Webhook", "Webhook", null, $webhookId, $ex);
    exit(1);
}

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 ResultPrinter::printResult("Delete a Webhook", "Webhook", $webhook->getId(), null, null);

return $output;
