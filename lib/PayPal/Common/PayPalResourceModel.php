<?php

namespace PayPal\Common;

use PayPal\Api\Links;
use PayPal\Handler\RestHandler;
use PayPal\Rest\ApiContext;
use PayPal\Rest\IResource;
use PayPal\Transport\PayPalRestCall;

/**
 * Class PayPalResourceModel
 * An Executable PayPalModel Class
 *
 * @property \PayPal\Api\Links[] links
 * @package PayPal\Common
 */
class PayPalResourceModel extends PayPalModel implements IResource
{

    /**
     * Sets Links
     *
     * @param Links[] $links
     *
     * @return $this
     */
    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     * Gets Links
     *
     * @return Links[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    public function getLink($rel)
    {
        if (is_array($this->links)) {
            foreach ($this->links as $link) {
                if ($link->getRel() == $rel) {
                    return $link->getHref();
                }
            }
        }
        return null;
    }

    /**
     * Append Links to the list.
     *
     * @param Links $links
     * @return $this
     */
    public function addLink($links)
    {
        if (!$this->getLinks()) {
            return $this->setLinks([$links]);
        } else {
            return $this->setLinks(
                array_merge($this->getLinks(), [$links])
            );
        }
    }

    /**
     * Remove Links from the list.
     *
     * @param Links $links
     * @return $this
     */
    public function removeLink($links)
    {
        return $this->setLinks(
            array_diff($this->getLinks(), [$links])
        );
    }


    /**
     * Execute SDK Call to Paypal services
     *
     * @param string      $url
     * @param string      $method
     * @param string      $payLoad
     * @param array $headers
     * @param ApiContext      $apiContext
     * @param PayPalRestCall      $restCall
     * @param array $handlers
     * @return string json response of the object
     */
    protected static function executeCall($url, $method, $payLoad, $headers = [], $apiContext = null, $restCall = null, $handlers = [RestHandler::class])
    {
        //Initialize the context and rest call object if not provided explicitly
        $apiContext = $apiContext ?: new ApiContext(self::$credential);
        $restCall = $restCall ?: new PayPalRestCall($apiContext);

        //Make the execution call
        $json = $restCall->execute($url, $method, $handlers, $payLoad, $headers);
        return $json;
    }

    /**
     * Updates Access Token using long lived refresh token
     *
     * @param string|null $refreshToken
     * @param ApiContext $apiContext
     * @return void
     */
    public function updateAccessToken($refreshToken, $apiContext)
    {
        $apiContext = $apiContext ?: new ApiContext(self::$credential);
        $apiContext->getCredential()->updateAccessToken($apiContext->getConfig(), $refreshToken);
    }
}
