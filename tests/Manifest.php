<?php
use GuzzleHttp\Client;

require_once('src/CustomTestCase.php');

/**
 * Manifest test
 */
class Manifest extends CustomTestCase
{
    /**
     * tearDown - clean up after test
     *
     * @return {type}  description
     */

    protected function tearDown()
    {
    }

    /**
     * testGET - testing some of the header values
     *
     * @return {type}  description
     */
    public function testHeaders()
    {
        $headers = $this->response->getHeaders();
        $this->assertEquals(200, $this->response->getStatusCode(), 'The status code is not 200');
        $this->assertEquals('application/json', $headers['Content-Type'][0], 'The content-type is not applicaiton/json');
        $this->assertTrue(isset($headers['ETag'][0]), 'ETag is missing');
    }

    /**
     * testCONTENT - testing the actual manifest response and calling the corresponding function
     *
     * @return {type}  description
     */
    public function testCONTENT()
    {
        foreach ($this->content as $key => $content) {
            $func = $content->type;
            if(method_exists(__CLASS__ , $func)){
                $this->$func($content);
            }
        }
    }

    /**
     * Issue - testing the issue part
     *
     * @param  {array} $content content of each issue in the manifest
     * @return {type}          description
     */
    public function Issue($content)
    {
        $this->assertEquals('Issue', $content->type, 'Issue type is not set');
        $this->assertTrue(isset($content->issueDate) , 'Issue date is not set');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $content->issueDate, 'Issue date ahs wrong format');
        $this->assertTrue(isset($content->nid) , 'Issue node ID is not set');
        $this->assertGreaterThan(1, intval($content->nid), 'Wrong issue node ID');
        $this->assertTrue(isset($content->bundleUri) , 'Issue bundle uri is not set');
        $this->assertRegExp('/((http:|https:)\/\/[.\/\w\-]+)/', $content->bundleUri, 'Wrong issue bundle uri format');
        $this->assertTrue(isset($content->jsonUri) , 'Issue json uri is not set');
        $this->assertRegExp('/(api\/v1\/issue\/(AP|US|EU)\/[0-9]{4}-[0-9]{2}-[0-9]{2}\/json)/', $content->jsonUri, 'Wrong issue json uri format');
        $this->assertTrue(isset($content->updateDate) , 'Issue update date is not set');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2})/', $content->updatedDate, 'Wrong issue update date format');
        $this->assertTrue(isset($content->nodeChild) , 'Issue node child is not set');
        $this->assertTrue(is_array($content->nodeChild), 'Issue node child is not array');
        $this->assertGreaterThan(0, count($content->nodeChild), 'nodeChild');
        $this->assertTrue(isset($content->issueChecksum) , 'Issue checksum is not set');
        $this->assertTrue(strlen($content->issueChecksum) == 32, 'Issue checksum has wrong length');
    }

    /**
     * weekend - testing the weekend part of the manifest
     *
     * @param  {array} $content content of the weekend part
     * @return {type}          description
     */
    public function weekend($content)
    {
        $this->assertEquals('weekend', $content->type, 'Weekend type is not set');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $content->issueDate, 'Date is not set for weekend message');
        if (isset($content->title) && $content->title !== '') {
            $title = true;
        }
        $this->assertTrue($title, 'Weekend message title is missing or it is empty');
        if (isset($content->message) && $content->message !== '') {
            $message = true;
        }
        $this->assertTrue($message, 'Weekend message is missing or it is empty');
    }

    /**
     * holiday - testing the holiday part of the manifest
     *
     * @param  {type} $content description
     * @return {type}          description
     */
    public function holiday($content)
    {
        $this->assertEquals('holiday', $content->type, 'Holiday type is not set');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $content->issueDate, 'Date is not set for holiday message');
        if (isset($content->title) && $content->title !== '') {
            $title = true;
        }
        $this->assertTrue($title, 'Holiday message title is missing or it is empty');
        if (isset($content->message) && $content->message !== '') {
            $message = true;
        }
        $this->assertTrue($message, 'Weekend message is missing or it is empty');
    }

    /**
     * advertChecksum - testing the checksum
     *
     * @param  {array} $content advert checksums
     * @return {type}          description
     */
    public function advertChecksum($content)
    {
    }
}
