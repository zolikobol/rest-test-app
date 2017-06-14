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
     * testAdvert - test for advert, calling ad for each element of advert endpoint
     *
     * @return {type}  description
     */
    public function testAdvert()
    {
        foreach ($this->content as $key => $content) {
          if(method_exists($this, $method_name)($this->ad)){
              $this->ad($content);
          }
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
        $this->assertTrue((isset($content->advertName) && $content->advertName !== ''), 'Advert name is missing or it is empty');
        $this->assertTrue(isset($content->nid) , 'Advert node ID is not set');
        $this->assertGreaterThan(1, intval($content->nid), 'Wrong advert node ID');
        $this->assertTrue(isset($content->region) , 'Advert region is not set');
        $this->assertContains($content->region, array('UK' , 'EU' , 'MEA', 'NA', 'LA', 'AP'), 'Incorrect advert region, allowed values are UK, EU, MEA, NA, LA, AP');
        $this->assertTrue(isset($content->dateFrom) , 'Advert date from is missing');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2})/', $content->dateFrom, 'Advert date from wrong format');
        $this->assertTrue(isset($content->dateTo) , 'Advert date to is missing');
        $this->assertRegExp('/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2})/', $content->dateTo, 'Advert date to wrong format');
        $this->assertTrue(isset($content->html) , 'Advert html is missing');
        $this->assertTrue((isset($content->html) && $content->html !== ''), 'Advert html wrong format');
        $this->assertTrue((isset($content->advertImage) && $content->advertImage !== ''), 'Advert image is missing or is empty');
    }
}
