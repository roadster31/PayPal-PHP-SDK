<?php

use PayPal\Api\Webhook;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
// # Update Webhook Sample
//
// This sample code demonstrate how to use this call to update a webhook; supports the replace operation only, as documented here at:
// https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_update
// API used: PATCH v1/notifications/webhooks/{webhook_id}
// ## Get Webhook ID.
// In samples we are using CreateWebhook.php sample to get the created instance of webhook.
// However, in real case scenario, we could use just the ID from database or use an already existing webhook.
/** @var Webhook $webhook */
$webhook = require 'CreateWebhook.php';
// Updating the webhook as per given request
//
//      [
//         {
//             "op":"replace",
//            "path":"/url",
//            "value":"https://requestb.in/10ujt3c1"
//         },
//         {
//             "op":"replace",
//            "path":"/event_types",
//            "value":[
//               {
//                   "name":"PAYMENT.SALE.REFUNDED"
//               }
//            ]
//         }
//      ]
$patch = new Patch();
$patch->setOp("replace")
    ->setPath("/url")
    ->setValue("https://requestb.in/10ujt3c1?uniqid=". uniqid());

$patch2 = new Patch();
$patch2->setOp("replace")
    ->setPath("/event_types")
    ->setValue(json_decode('[{"name":"PAYMENT.SALE.REFUNDED"}]'));

$patchRequest = new PatchRequest();
$patchRequest->addPatch($patch)->addPatch($patch2);

// ### Get Webhook
try {
    $output = $webhook->update($patchRequest, $apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("Updated a Webhook", "Webhook", null, $patchRequest, $ex);
    exit(1);
}

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 ResultPrinter::printResult("Updated a Webhook", "Webhook", $output->getId(), $patchRequest, $output);

return $output;
