<?php
use GuzzleHttp\Client;
require_once('src/CustomTestCase.php');

class TestSkeleton extends CustomTestCase {

  protected function tearDown(){}

  public function testBundle() {
    foreach ($this->content as $key => $content) {
      $func = strtolower(str_replace(' ', '', $content->type));
      $this->$func($content);
    }
  }
}
