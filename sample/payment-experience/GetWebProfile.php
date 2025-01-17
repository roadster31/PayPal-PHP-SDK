<?php

use PayPal\Api\CreateProfileResponse;
use PayPal\Api\WebProfile;
use PayPal\Exception\PayPalConnectionException;
// ### Get Web Profile
// If your request is successful, the API returns a web_profile object response that contains the profile details.
// Documentation available at https://developer.paypal.com/docs/api/#retrieve-a-web-experience-profile
// We are going to re-use the sample code from CreateWebProfile.php.
// If you have not visited the sample yet, please visit it before trying GetWebProfile.php
// The CreateWebProfile.php will create a web profile for us, and return a CreateProfileResponse,
// that contains the web profile ID.
/** @var CreateProfileResponse $result */
$createProfileResponse = require 'CreateWebProfile.php';

try {
    // If your request is successful, the API returns a web_profile object response that contains the profile details.
    $webProfile = WebProfile::get($createProfileResponse->getId(), $apiContext);
} catch (PayPalConnectionException $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("Get Web Profile", "Web Profile", $webProfile->getId(), null, $ex);
    exit(1);
}

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 ResultPrinter::printResult("Get Web Profile", "Web Profile", $webProfile->getId(), null, $webProfile);

return $webProfile;
