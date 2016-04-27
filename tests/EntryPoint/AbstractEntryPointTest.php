<?php

namespace SugarAPI\SDK\Tests\EntryPoint;

use SugarAPI\SDK\Request\DELETE;
use SugarAPI\SDK\Request\GET;
use SugarAPI\SDK\Request\GETFile;
use SugarAPI\SDK\Request\POST;
use SugarAPI\SDK\Request\POSTFile;
use SugarAPI\SDK\Request\PUT;
use SugarAPI\SDK\Tests\Stubs\EntryPoint\EntryPointStub;

/**
 * Class AbstractEntryPointTest
 * @package SugarAPI\SDK\Tests\EntryPoint
 * @coversDefaultClass SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint
 * @group entrypoints
 */
class AbstractEntryPointTest extends \PHPUnit_Framework_TestCase {

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
     * @return EntryPointStub $Stub
     * @covers ::__construct
     * @group abstractEP
     */
    public function testConstructor(){
        $Stub = new EntryPointStub($this->url);
        $this->assertEquals('http://localhost/rest/v10/$test',$Stub->getUrl());
        $this->assertEquals(array(),$Stub->getOptions());
        $this->assertEmpty($Stub->getData());
        $this->assertEmpty($Stub->getRequest());
        $this->assertEmpty($Stub->getResponse());

        unset($Stub);
        $Stub = new EntryPointStub($this->url,$this->options);
        $this->assertEquals($this->url.'foo',$Stub->getUrl());
        $this->assertEquals($this->options,$Stub->getOptions());
        $this->assertEmpty($Stub->getData());
        $this->assertEmpty($Stub->getRequest());
        $this->assertEmpty($Stub->getResponse());
        
        return $Stub;
    }

    /**
     * @param EntryPointStub $Stub
     * @return EntryPointStub $Stub
     * @depends testConstructor
     * @covers ::setOptions
     * @covers ::getOptions
     * @covers ::getUrl
     * @covers ::configureUrl
     * @group abstractEP
     */
    public function testSetOptions($Stub){
        $Stub->setOptions(array());
        $this->assertEquals($this->url.'$test',$Stub->getUrl());
        $this->assertEquals(array(),$Stub->getOptions());
        $Stub->setOptions($this->options);
        $this->assertEquals($this->url.'foo',$Stub->getUrl());
        $this->assertEquals($this->options,$Stub->getOptions());
        
        return $Stub;
    }

    /**
     * @param EntryPointStub $Stub
     * @return EntryPointStub $Stub
     * @depends testSetOptions
     * @covers ::setData
     * @covers ::getData
     * @group abstractEP
     */
    public function testSetData($Stub){
        $Stub->setData(array());
        $this->assertEquals(array(),$Stub->getData());
        $Stub->setData('string');
        $this->assertEquals('string',$Stub->getData());
        $class = new \stdClass();
        $class->foo = 'bar';
        $Stub->setData($class);
        $this->assertEquals($class,$Stub->getData());
        unset($class);
        $Stub->setData($this->data);
        return $Stub;
    }

    /**
     * @param EntryPointStub $Stub
     * @return EntryPointStub $Stub
     * @depends testSetData
     * @covers ::setRequest
     * @covers ::getRequest
     * @group abstractEP
     */
    public function testSetRequest($Stub){
        $GET = new GET();
        $POST = new POST();
        $POSTFile = new POSTFile();
        $PUT = new PUT();
        $DELETE = new DELETE();
        $GETFile = new GETFile();
        $Stub->setRequest($POST);
        $this->assertEquals($POST,$Stub->getRequest());
        unset($POST);
        $Stub->setRequest($POSTFile);
        $this->assertEquals($POSTFile,$Stub->getRequest());
        unset($POSTFile);
        $Stub->setRequest($PUT);
        $this->assertEquals($PUT,$Stub->getRequest());
        unset($PUT);
        $Stub->setRequest($DELETE);
        $this->assertEquals($DELETE,$Stub->getRequest());
        unset($DELETE);
        $Stub->setRequest($GETFile);
        $this->assertEquals($GETFile,$Stub->getRequest());
        unset($GETFile);
        $Stub->setRequest($GET);
        $this->assertEquals($GET,$Stub->getRequest());
        return $Stub;
    }

    /**
     * @param EntryPointStub $Stub
     * @return EntryPointStub $Stub
     * @depends testSetRequest
     * @covers ::setAuth
     * @covers ::authRequired
     * @group abstractEP
     */
    public function testSetAuth($Stub){
        $Stub->setAuth('1234');
        $this->assertEquals(true,$Stub->authRequired());
        return $Stub;
    }

    /**
     * @param EntryPointStub $Stub
     * @return EntryPointStub $Stub
     * @depends testSetAuth
     * @covers ::execute
     * @covers ::configureRequest
     * @covers ::verifyUrl
     * @covers ::verifyData
     * @covers ::verifyRequiredData
     * @covers ::verifyDataType
     * @covers ::verifyOptions
     * @covers ::configureData
     * @covers ::configureDefaultData
     * @covers ::configureUrl
     * @covers ::configureAuth
     * @group abstractEP
     */
    public function testExecute($Stub){
        $Stub->execute();
        $this->assertEquals(array(
                                'foo' => 'bar',
                                'bar' => 'foo'
        ),$Stub->getData());
        $this->assertEquals($this->url.'foo?foo=bar&bar=foo',$Stub->getRequest()->getUrl());
        $this->assertEquals(array('OAuth-Token: 1234'),$Stub->getRequest()->getHeaders());
    }

    /**
     * @covers ::verifyDataType
     * @expectedException SugarAPI\SDK\Exception\EntryPoint\RequiredDataException
     * @expectedExceptionMessageRegExp /Valid DataType is array/
     * @group abstractEP
     */
    public function testInvalidDataType(){
        $Stub = new EntryPointStub($this->url);
        $Stub->setOptions($this->options);
        $Stub->setRequest(new POST());
        $class = new \stdClass();
        $class->foo = 'bar';
        $Stub->setData($class);
        $Stub->execute();
    }

    /**
     * @covers ::verifyRequiredData
     * @expectedException SugarAPI\SDK\Exception\EntryPoint\RequiredDataException
     * @expectedExceptionMessageRegExp /Missing data for/
     * @group abstractEP
     */
    public function testInvalidData(){
        $Stub = new EntryPointStub($this->url);
        $Stub->setOptions($this->options);
        $Stub->setRequest(new POST());
        $Stub->setData(array());
        $Stub->execute();
    }

    /**
     * @covers ::execute
     * @expectedException SugarAPI\SDK\Exception\EntryPoint\InvalidRequestException
     * @expectedExceptionMessageRegExp /Request property not configured/
     * @group abstractEP
     */
    public function testInvalidRequest(){
        $Stub = new EntryPointStub($this->url);
        $Stub->setOptions($this->options);
        $Stub->setData($this->data);
        $Stub->execute();
    }



}
