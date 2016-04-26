<?php

namespace SugarAPI\SDK\Tests\EntryPoint\DELETE;

use SugarAPI\SDK\Request\DELETE;
use SugarAPI\SDK\Tests\Stubs\DeleteEntryPointStub;

/**
 * Class AbstractEntryPointTest
 * @package SugarAPI\SDK\Tests\EntryPoint
 * @coversDefaultClass SugarAPI\SDK\EntryPoint\Abstracts\DELETE\AbstractDeleteEntryPoint
 * @group entrypoints
 */
class AbstractDeleteEntryPointTest extends \PHPUnit_Framework_TestCase {

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    protected $url = 'http://localhost/rest/v10/';
    protected $options = array('foo');
    protected $data = array(
        'foo' => 'bar'
    );

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @return DeleteEntryPointStub $Stub
     * @covers ::__construct
     * @group abstractEP
     */
    public function testConstructor(){
        $Stub = new DeleteEntryPointStub($this->url);
        $this->assertNotEmpty($Stub->getRequest());
        $this->assertEquals('http://localhost/rest/v10/$test',$Stub->getUrl());
        $this->assertEquals(array(),$Stub->getOptions());
        $this->assertEmpty($Stub->getData());
        $this->assertEmpty($Stub->getResponse());

        unset($Stub);
        $Stub = new DeleteEntryPointStub($this->url,$this->options);
        $this->assertNotEmpty($Stub->getRequest());
        $this->assertEquals($this->url.'foo',$Stub->getUrl());
        $this->assertEquals($this->options,$Stub->getOptions());
        $this->assertEmpty($Stub->getData());
        $this->assertEmpty($Stub->getResponse());

        unset($Delete);
        return $Stub;
    }

    /**
     * @param DeleteEntryPointStub $Stub
     * @depends testConstructor
     * @covers ::execute
     * @group abstractEP
     */
    public function testExecute($Stub){
        $Stub->execute($this->data);
        $this->assertNotEmpty($Stub->getResponse());
    }

}
