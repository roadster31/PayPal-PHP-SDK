<?php

use PayPal\Api\Webhook;
use PayPal\Api\WebhookEventType;
// # Get Webhook Sample
//
// This sample code demonstrate how you can get a webhook, as documented here at:
// https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_get
// API used: GET /v1/notifications/webhooks/{webhook_id}
// ## List Subscribed Event Types
// Use this call to retrieve the list of events types that are subscribed to a webhook.
/** @var Webhook $webhook */
$webhook = require 'CreateWebhook.php';
$webhookId = $webhook->getId();

// ### Get List of Subscribed Event Types
try {
    $output = WebhookEventType::subscribedEventTypes($webhookId, $apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("List subscribed webhook event types", "WebhookEventTypeList", null, $webhookId, $ex);
    exit(1);
}

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 ResultPrinter::printResult("List subscribed webhook event types", "WebhookEventTypeList", null, null, $output);

return $output;
