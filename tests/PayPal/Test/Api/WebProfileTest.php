<?php

namespace PayPal\Test\Api;

use PayPal\Transport\PayPalRestCall;
use PayPal\Api\WebProfile;
use PHPUnit\Framework\TestCase;

/**
 * Class WebProfile
 *
 * @package PayPal\Test\Api
 */
class WebProfileTest extends TestCase
{
    /**
     * Gets Json String of Object WebProfile
     * @return string
     */
    public static function getJson()
    {
        return '{"id":"TestSample","name":"TestSample","temporary":true,"flow_config":' .FlowConfigTest::getJson() . ',"input_fields":' .InputFieldsTest::getJson() . ',"presentation":' .PresentationTest::getJson() . '}';
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return WebProfile
     */
    public static function getObject()
    {
        return new WebProfile(self::getJson());
    }


    /**
     * Tests for Serialization and Deserialization Issues
     * @return WebProfile
     */
    public function testSerializationDeserialization()
    {
        $obj = new WebProfile(self::getJson());
        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getId());
        $this->assertNotNull($obj->getName());
        $this->assertNotNull($obj->getTemporary());
        $this->assertNotNull($obj->getFlowConfig());
        $this->assertNotNull($obj->getInputFields());
        $this->assertNotNull($obj->getPresentation());
        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param WebProfile $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getId(), "TestSample");
        $this->assertEquals($obj->getName(), "TestSample");
        $this->assertEquals($obj->getTemporary(), true);
        $this->assertEquals($obj->getFlowConfig(), FlowConfigTest::getObject());
        $this->assertEquals($obj->getInputFields(), InputFieldsTest::getObject());
        $this->assertEquals($obj->getPresentation(), PresentationTest::getObject());
    }

    /**
     * @dataProvider mockProvider
     * @param WebProfile $obj
     */
    public function testCreate($obj, $mockApiContext)
    {
        $mockPPRestCall = $this->getMockBuilder('\\' . PayPalRestCall::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPPRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                    self::getJson()
            ));

        $result = $obj->create($mockApiContext, $mockPPRestCall);
        $this->assertNotNull($result);
    }
    /**
     * @dataProvider mockProvider
     * @param WebProfile $obj
     */
    public function testUpdate($obj, $mockApiContext)
    {
        $mockPPRestCall = $this->getMockBuilder('\\' . PayPalRestCall::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPPRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                    true
            ));

        $result = $obj->update($mockApiContext, $mockPPRestCall);
        $this->assertNotNull($result);
    }
    /**
     * @dataProvider mockProvider
     * @param WebProfile $obj
     */
    public function testPartialUpdate($obj, $mockApiContext)
    {
        $mockPPRestCall = $this->getMockBuilder('\\' . PayPalRestCall::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPPRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                    true
            ));
        $patch = [PatchTest::getObject()];

        $result = $obj->partial_update($patch, $mockApiContext, $mockPPRestCall);
        $this->assertNotNull($result);
    }
    /**
     * @dataProvider mockProvider
     * @param WebProfile $obj
     */
    public function testGet($obj, $mockApiContext)
    {
        $mockPPRestCall = $this->getMockBuilder('\\' . PayPalRestCall::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPPRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                    WebProfileTest::getJson()
            ));

        $result = $obj->get("profileId", $mockApiContext, $mockPPRestCall);
        $this->assertNotNull($result);
    }
    /**
     * @dataProvider mockProvider
     * @param WebProfile $obj
     */
    public function testGetList($obj, $mockApiContext)
    {
        $mockPPRestCall = $this->getMockBuilder('\\' . PayPalRestCall::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPPRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                    json_encode([json_decode(WebProfileTest::getJson(), null, 512, JSON_THROW_ON_ERROR)], JSON_THROW_ON_ERROR)
            ));

        $result = $obj->get_list($mockApiContext, $mockPPRestCall);
        $this->assertNotNull($result);
    }
    /**
     * @dataProvider mockProvider
     * @param WebProfile $obj
     */
    public function testDelete($obj, $mockApiContext)
    {
        $mockPPRestCall = $this->getMockBuilder('\\' . PayPalRestCall::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPPRestCall->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(
                    true
            ));

        $result = $obj->delete($mockApiContext, $mockPPRestCall);
        $this->assertNotNull($result);
    }

    public function mockProvider()
    {
        $obj = self::getObject();
        $mockApiContext = $this->getMockBuilder('ApiContext')
                    ->disableOriginalConstructor()
                    ->getMock();
        return [[$obj, $mockApiContext], [$obj, null]];
    }
}
