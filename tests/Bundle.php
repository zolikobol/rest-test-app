<?php
use GuzzleHttp\Client;

require_once('src/CustomTestCase.php');

/**
 * Bundle test
 */
class Bundle extends CustomTestCase
{
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
     * testBundle - checking each element of bundle and calling the corresponding test function
     *
     * @return {type}  description
     */
    public function testBundle()
    {
        foreach ($this->content as $key => $content) {
            $this->assertTrue(isset($content->region), 'The issue region is not set');
            $func = strtolower(str_replace(' ', '', $content->type));
            if(method_exists(__CLASS__ , $func)){
              $this->$func($content);
            }
        }
    }

    /**
     * issue - testing the issue part of the bundle
     *
     * @param  {array} $content the content if actual issue
     * @return {type}          description
     */
    public function issue($content)
    {
        $this->assertContains($content->region, array('AP' , 'EU' , 'US'), 'The issue region is not one from AP, EU or US');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $content->issueDate, 'The issue date is not in correct format');
        $this->assertGreaterThan(1, intval($content->nid), 'Wrong issue node ID');
        $this->assertTrue(isset($content->nid), 'Issue node ID is not set');
        $this->assertTrue(isset($content->updatedDate), 'Issue update date is not set');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2})/', $content->updatedDate, 'The issue update date is not in correct format');
        $this->assertTrue(isset($content->headlineSummary), 'Issue headline summary is missing');
        $this->assertTrue(isset($content->zinger), 'Issue zinger is missing');
        $this->assertTrue(isset($content->dataTimestamp), 'Issue dateTimestamp is missing');
        $this->assertTrue(isset($content->owner), 'Issue owner field is missing');
        if (isset($content->zingerAuthor)) {
            $this->assertTrue($content->zingerAuthor !== '', 'Zinger author is set but with an empty value');
        }
    }

    /**
     * article - testing the articles of the issue
     *
     * @param  {array} $content the content of actual article
     * @return {type}          description
     */
    public function article($content)
    {
        $this->assertTrue((isset($content->headline) && $content->headline !== ''), 'Article headline is missing or is empty');
        $this->assertTrue((isset($content->body) && $content->body !== ''), 'Article body is missing or is empty');
        $this->assertTrue((isset($content->leaderImage) && $content->leaderImage !== ''), 'Leader image is missing or is empty');
        $this->assertGreaterThan(1, intval($content->nid), 'Wrong article node ID');
        $this->assertTrue(isset($content->nid), 'Article node ID is not set');
        $this->assertTrue(strlen($content->nhash) == 32, 'Article nhash has wrong length');
        $this->assertTrue(isset($content->nhash), 'Article nhash is is not set');
        $this->assertTrue(isset($content->owner), 'Article owner field is missing');

        if (isset($content->leaderPictureCredit)) {
            $this->assertTrue($content->leaderPictureCredit !== '', 'Article leader picture is set but with an empty value');
        }
        if (isset($content->image)) {
            $this->assertTrue($content->image !== '', 'Article picture is set but with an empty value');
        }
        if (isset($content->linkOneUrl)) {
            $this->assertTrue($content->linkOneUrl !== '', 'Article link one URL is set but with an empty value');
        }
        if (isset($content->linkOneTitle)) {
            $this->assertTrue($content->linkOneTitle !== '', 'Article link one title is set but with an empty value');
        }
        if (isset($content->linkTwoUrl)) {
            $this->assertTrue($content->linkTwoUrl !== '', 'Article link two URL is set but with an empty value');
        }
        if (isset($content->linkTwoTitle)) {
            $this->assertTrue($content->linkTwoTitle !== '', 'Article link two title is set but with an empty value');
        }
        if (isset($content->shareLink)) {
            $this->assertRegExp('/((http:|https:)\/\/[.\/\w\-]+)/', $content->shareLink, 'Article share link has wrong format');
        }
    }

    /**
     * gobbet_page - testing the gobbet page of the issue
     *
     * @param  {array} $content the content of actual gobbet
     * @return {type}          description
     */
    public function gobbet_page($content)
    {
        $this->assertTrue((isset($content->body) && $content->body !== ''), 'Gobbet page body is missing or is empty');
        $this->assertTrue(isset($content->nid), 'Node ID is not set');
        $this->assertGreaterThan(1, intval($content->nid), 'Wrong gobbet node ID');
        $this->assertTrue(isset($content->nhash), 'Gobbet nhash is is not set');
        $this->assertTrue(strlen($content->nhash) == 32, 'Gobbet nhash has wrong length');
        $this->assertTrue(isset($content->owner), 'Gobbet owner is not set');
        if (isset($content->image)) {
            $this->assertTrue($content->image !== '', 'Gobbet image is set but is empty');
            $this->assertRegExp('/((http:|https:)\/\/[.\/\w\-]+)/', $content->shareLink, 'Gobbet share link has wrong format');
        }
    }

    /**
     * fxrate - testing the FX Rate
     *
     * @param  {array} $content the content of actual fx rate
     * @return {type}          description
     */
    public function fxrate($content)
    {
        echo $content->type;
    }

    /**
     * marketindex - teting the market indexes
     *
     * @param  {array} $content the content of actual market index
     * @return {type}          description
     */
    public function marketindex($content)
    {
        echo $content->type;
    }
}
