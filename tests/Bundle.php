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
     * testBundle - checking each element of bundle and calling the corresponding test function
     *
     * @return {type}  description
     */
    public function testBundle()
    {
        foreach ($this->content as $key => $content) {
            $func = strtolower(str_replace(' ', '', $content->type));
            $this->$func($content);
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
        $this->assertContains($content->region, array('AP' , 'EU' , 'US'));
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2})/', $content->issueDate, 'issueDate');
        $this->assertGreaterThan(1, intval($content->nid), 'nid');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2})/', $content->updatedDate, 'updatedDate');
        $this->assertTrue(isset($content->headlineSummary), 'headlineSummary');
        $this->assertTrue(isset($content->zinger), 'headlineSummary');
        $this->assertTrue(isset($content->zingerAuthor), 'zingerAuthor');
        $this->assertTrue(isset($content->owner), 'owner');
    }

    /**
     * article - testing the articles of the issue
     *
     * @param  {array} $content the content of actual article
     * @return {type}          description
     */
    public function article($content)
    {
        $this->assertTrue((isset($content->headline) && $content->headline !== ''), 'headline');
        $this->assertTrue((isset($content->body) && $content->body !== ''), 'body');
        $this->assertTrue((isset($content->leaderImage) && $content->leaderImage !== ''), 'leaderImage');
        $this->assertTrue((isset($content->leaderPictureCredit) && $content->leaderPictureCredit !== ''), 'leaderPictureCredit');
        $this->assertRegExp('/((http:|https:)\/\/[.\/\w\-]+)/', $content->shareLink, 'shareLink');
        $this->assertGreaterThan(1, intval($content->nid), 'nid');
        $this->assertTrue(strlen($content->nhash) == 32, 'nhash');
        $this->assertTrue(isset($content->owner), 'owner');
    }

    /**
     * gobbet_page - testing the gobbet page of the issue
     *
     * @param  {array} $content the content of actual gobbet
     * @return {type}          description
     */
    public function gobbet_page($content)
    {
        $this->assertTrue((isset($content->body) && $content->body !== ''), 'body');
        $this->assertGreaterThan(1, intval($content->nid), 'nid');
        $this->assertTrue(strlen($content->nhash) == 32, 'nhash');
        $this->assertTrue(isset($content->owner), 'owner');
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
