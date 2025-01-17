<?php

use PayPal\Api\CreateProfileResponse;
use PayPal\Api\WebProfile;
use PayPal\Exception\PayPalConnectionException;
// #### Delete Web Profile
// Use this call to delete a web experience profile.
// Documentation available at https://developer.paypal.com/docs/api/#delete-a-web-experience-profile
// We are going to re-use the sample code from CreateWebProfile.php.
// If you have not visited the sample yet, please visit it before trying GetWebProfile.php
// The CreateWebProfile.php will create a web profile for us, and return a CreateProfileResponse,
// that contains the web profile ID.
/** @var CreateProfileResponse $result */
$createProfileResponse = require_once 'CreateWebProfile.php';

// Create a new instance of web Profile ID, and set the ID.
$webProfile = new WebProfile();
$webProfile->setId($createProfileResponse->getId());

try {
    // Execute the delete method
    $webProfile->delete($apiContext);
} catch (PayPalConnectionException $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("Deleted Web Profile", "Web Profile", $createProfileResponse->getId(), null, $ex);
    exit(1);
}

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 ResultPrinter::printResult("Deleted Web Profile", "Web Profile", $createProfileResponse->getId(), null, null);
