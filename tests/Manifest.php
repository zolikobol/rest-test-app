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
    public function testGET()
    {
        $this->assertEquals(200, $this->response->getStatusCode());
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
            $this->$func($content);
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
        $this->assertEquals('Issue', $content->type, 'type');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $content->issueDate, 'issueDate');
        $this->assertRegExp('/((http:|https:)\/\/[.\/\w\-]+)/', $content->bundleUri, 'budnleUri');
        $this->assertRegExp('/(api\/v1\/issue\/(AP|US|EU)\/[0-9]{4}-[0-9]{2}-[0-9]{2}\/json)/', $content->jsonUri, 'jsonUri');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2})/', $content->updatedDate, 'updatedDate');
        $this->assertTrue(is_array($content->nodeChild), 'nodeChild');
        $this->assertGreaterThan(0, count($content->nodeChild), 'nodeChild');
        $this->assertTrue(strlen($content->issueChecksum) == 32, 'issueChecksum');
        $this->assertGreaterThan(1, intval($content->nid), 'nid');
    }

    /**
     * weekend - testing the weekend part of the manifest
     *
     * @param  {array} $content content of the weekend part
     * @return {type}          description
     */
    public function weekend($content)
    {
        $this->assertEquals('weekend', $content->type, 'type');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $content->issueDate, 'issueDate');
        if (isset($content->title) && $content->title !== '') {
            $title = true;
        }
        $this->assertTrue($title, 'title');
        if (isset($content->message) && $content->message !== '') {
            $message = true;
        }
        $this->assertTrue($message, 'message');
    }

    /**
     * holiday - testing the holiday part of the manifest
     *
     * @param  {type} $content description
     * @return {type}          description
     */
    public function holiday($content)
    {
        $this->assertEquals('holiday', $content->type, 'type');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $content->issueDate, 'issueDate');
        if (isset($content->title) && $content->title !== '') {
            $title = true;
        }
        $this->assertTrue($title, 'title');
        if (isset($content->message) && $content->message !== '') {
            $message = true;
        }
        $this->assertTrue($message, 'message');
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
