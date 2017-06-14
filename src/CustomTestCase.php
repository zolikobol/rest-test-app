<?php
use GuzzleHttp\Client;

/**
 * This class extends the PHPUnit_Framework_TestCase with setup and requests calling
 */
class CustomTestCase extends PHPUnit_Framework_TestCase
{
    protected $content = array();

    protected $header = array();

    protected $response = array();

    protected $client;

    protected $env = array(
    'QA' => 'http://qa.espresso.economist.com',
    'PROD' => 'http://espresso.economist.com'
  );

    protected $args = array();

    /**
     * setUp - setting up the Client
     *
     * @return {type}  description
     */
    protected function setUp()
    {
        $args = $_SERVER['argv'];


        if(!isset($args[0]) || !isset($args[1]) || !isset($args[2])){
          echo 'The first 3 parameters must be set in this order: phpunit --bootstrap=vendor/autoload.php test/TestClass.php' . PHP_EOL;
          exit;
        }

        $file = split('/', $args[2]);
        $endpoint = split('\.', $file[1]);

        unset($args[0], $args[1], $args[2]);

        $this->args = $this->getArguments($args);

        $this->client = new Client([
        'base_uri' => $this->env[$this->args['env']],
    ]);

        $request = 'get' . ucfirst($endpoint[0]) . 'Request';

        $this->$request();
    }

    /**
     * getManifestRequest - making request to manifest endpoint and parsing the response
     *
     * @return {type}  description
     */
    protected function getManifestRequest()
    {
        try {
            $this->response = $this->client->request('GET', '/api/v1/issue/' . $this->args['region'] . '/json');
        } catch (Exception $e) {
            echo 'Wrong parameters resulted in bad request!' . PHP_EOL;
            exit;
        }

        $this->header = $this->response->getHeaders();

        $this->content = json_decode($this->response->getBody());
    }

    /**
     * getBundleRequest - making request to bundle endpoint and parsin the response
     *
     * @return {type}  description
     */
    protected function getBundleRequest()
    {
        try {
            $this->response = $this->client->request('GET', '/api/v1/issue/' . $this->args['region'] . '/' . $this->args['date'] . '/json');
        } catch (Exception $e) {
            echo 'Wrong parameters resulted in bad request!' . PHP_EOL;
            exit;
        }

        $this->header = $this->response->getHeaders();

        $this->content = json_decode($this->response->getBody());
    }

    /**
     * getAdvertRequest - making request to advert endpoint and parsin the response
     *
     * @return {type}  description
     */
    protected function getAdvertRequest()
    {
        try {
            $this->response = $this->client->request('GET', '/api/v1/ad/' . $this->args['region'] . '/json');
        } catch (Exception $e) {
            echo 'Wrong parameters resulted in bad request!' . PHP_EOL;
            exit;
        }

        $this->header = $this->response->getHeaders();

        $this->content = json_decode($this->response->getBody());
    }

    /**
     * tearDown - cleaning up the class
     *
     * @return {type}  description
     */
    protected function tearDown()
    {
    }

    /**
     * getArguments - parsing the cli arguments
     *
     * @param  {type} $args description
     * @return {type}       description
     */
    protected function getArguments($args)
    {
        $arguments = array();

        foreach ($args as $key => $value) {
            $splitted = split('=', $value);

            $arguments[$splitted[0]] = $splitted[1];
        }

        return $arguments;
    }
}
