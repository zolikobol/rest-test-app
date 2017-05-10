<?php
use GuzzleHttp\Client;

require_once('src/CustomTestCase.php');

/**
 * Advert test
 */
class Advert extends CustomTestCase
{
    /**
     * tearDown - clean up after the test
     *
     * @return {type}  description
     */

    protected function tearDown()
    {
    }

    /**
     * testAdvert - test for advert, calling ad for each element of advert endpoint
     *
     * @return {type}  description
     */
    public function testAdvert()
    {
        foreach ($this->content as $key => $content) {
            $this->ad($content);
        }
    }

    /**
     * ad - the actual advert test method, here we check for response data and verify them
     *
     * @param  {array} $content content of the actual advert
     * @return {type}          description
     */
    public function ad($content)
    {
        $this->assertTrue((isset($content->advertName) && $content->advertName !== ''), 'advertName');
        $this->assertGreaterThan(1, intval($content->nid), 'nid');
        $this->assertContains($content->region, array('UK' , 'EU' , 'MEA', 'NA', 'LA', 'AP'));
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2})/', $content->dateFrom, 'dateFrom');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2})/', $content->dateTo, 'dateTo');
        $this->assertTrue((isset($content->html) && $content->html !== ''), 'html');
        $this->assertTrue((isset($content->advertImage) && $content->advertImage !== ''), 'advertImage');
    }
}
