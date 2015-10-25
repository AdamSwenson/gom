<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/22/15
 * Time: 12:52 PM
 */

namespace App\Http\Controllers\helpers\validation;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class StudentRecordValidatorTest extends \TestCase
{

    public $request;
    public $tooLong;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new StudentRecordValidator;
        $this->request = new FormRequest();

        $this->tooLong = 'smith';
        for($i=0; $i<500; $i++)
        {
            $this->tooLong .= 'smith';
        }
    }

    public function tearDown()
    {
        unset($this->object);
        unset($this->request);
    }

public function loadTestDataIntoRequest($data)
{
    $flat = [];
    foreach($data as $d)
    {
        foreach($d as $k => $v)
        {
            $this->request[$k] = $v;
            $flat[$k] = $v;
            $_POST[$k] = $v;
        }
    }
    $this->assertEquals($flat, $this->request->all());
}

    /**
     * @test
     */
    public function validateStudentsEverythingFine()
    {
        //prep
        $data = [
            [
                'lastName1' => 'smith',
                'firstName1' => 'jill',
                'email1' => 'jill@smith.com',
                'studentIdentifier1' => '1234567',
                'id1' => '200'],
            [ 'lastName2' => 'jillson',
                'firstName2' => 'smitty',
                'email2' => 'smitty@jill.com',
                'studentIdentifier2' => '7654321',
                'id2' => '201']
        ];

        $this->loadTestDataIntoRequest($data);

        //call
        $this->object->validateStudents($this->request);

        //check
        $this->assertAttributeContains(1, 'validRecords', $this->object, 'Id1 in validRecords');
        $this->assertAttributeContains(2, 'validRecords', $this->object, 'Id2 in validRecords');
    }

    /**
     * @test
     */
    public function lastNameTooShort()
    {
        //prep
        $data = [
            [
                'lastName1' => 'smith',
                'firstName1' => 'jill',
                'email1' => 'jill@smith.com',
                'studentIdentifier1' => '1234567',
                'id1' => '200'],
            [ 'lastName2' => 'j',
                'firstName2' => 'smitty',
                'email2' => 'smitty@jill.com',
                'studentIdentifier2' => '7654321',
                'id2' => '201']
        ];

        $this->loadTestDataIntoRequest($data);

        //call
        $this->object->validateStudents($this->request);

        //check
        $this->assertAttributeContains(1, 'validRecords', $this->object, 'Id1 in validRecords');
        $this->assertAttributeContains('2', 'invalidRecords', $this->object, 'Id2 was correctly identified as invalid');
    }

    /**
     * @test
     */
    public function lastNameTooLong()
    {
        //prep
        $data = [
            [
                'lastName1' => $this->tooLong,
                'firstName1' => 'jill',
                'email1' => 'jill@smith.com',
                'studentIdentifier1' => '1234567',
                'id1' => '200'],
            [ 'lastName2' => 'smit',
                'firstName2' => 'smitty',
                'email2' => 'smitty@jill.com',
                'studentIdentifier2' => '7654321',
                'id2' => '201']
        ];

        $this->loadTestDataIntoRequest($data);

        //call
        $this->object->validateStudents($this->request);

        //check
        $this->assertAttributeContains(2, 'validRecords', $this->object, 'Id2 in validRecords');
        $this->assertAttributeContains(1, 'invalidRecords', $this->object, 'Id1 correctly identified as invalid');
    }

    /**
     * @test
     */
    public function lastNameEmpty()
    {
        //prep
        $data = [
            [
                'lastName1' => '',
                'firstName1' => 'jill',
                'email1' => 'jill@smith.com',
                'studentIdentifier1' => '1234567',
                'id1' => '200'],
            [ 'lastName2' => 'smit',
                'firstName2' => 'smitty',
                'email2' => 'smitty@jill.com',
                'studentIdentifier2' => '7654321',
                'id2' => '201']
        ];

        $this->loadTestDataIntoRequest($data);

        //call
        $this->object->validateStudents($this->request);

        //check
        $this->assertEquals([1], $this->object->invalidRecords, 'Id1 correctly identified as invalid');
        $this->assertEquals([2], $this->object->validRecords, 'Id2 is correctly identified as valid');

        $this->assertAttributeContains(1, 'invalidRecords', $this->object, 'Id1 correctly identified as invalid');
        $this->assertAttributeContains(2, 'validRecords', $this->object, 'Id2 in validRecords');

        $this->assertEquals(1, $this->object->errorMessages->count());
//        $this->assertTrue($this->object->errorMessages->has('lastName1.min'), 'error message for rule in bag');
//        $this->assertArrayHasKey('lastName1.min', $this->object->errorMessages->all(), 'error message for rule in bag');
    }



    /**
     * @test
     */
    public function firstNameEmpty()
    {
        //prep
        $data = [
            [
                'lastName1' => 'smith',
                'firstName1' => '',
                'email1' => 'jill@smith.com',
                'studentIdentifier1' => '1234567',
                'id1' => '200'],
            [ 'lastName2' => 'jsssss',
                'firstName2' => 'smitty',
                'email2' => 'smitty@jill.com',
                'studentIdentifier2' => '7654321',
                'id2' => '201']
        ];

        $this->loadTestDataIntoRequest($data);

        //call
        $this->object->validateStudents($this->request);

        //check
        $this->assertEquals([1], $this->object->invalidRecords, 'Id1 was correctly identified as invalid');
        $this->assertEquals([2], $this->object->validRecords, 'Id2 was correctly identified as valid');

        $this->assertAttributeContains(2, 'validRecords', $this->object, 'Id2 in validRecords');
        $this->assertAttributeContains(1, 'invalidRecords', $this->object, 'Id1 was correctly identified as invalid');
    }

    /**
     * @test
     */
    public function firstNameTooLong()
    {
        //prep
        $data = [
            [
                'lastName1' => 'smith',
                'firstName1' => $this->tooLong,
                'email1' => 'jill@smith.com',
                'studentIdentifier1' => '1234567',
                'id1' => '200'],
            [ 'lastName2' => 'smit',
                'firstName2' => 'smitty',
                'email2' => 'smitty@jill.com',
                'studentIdentifier2' => '7654321',
                'id2' => '201']
        ];

        $this->loadTestDataIntoRequest($data);

        //call
        $this->object->validateStudents($this->request);

        //check
        $this->assertAttributeContains(2, 'validRecords', $this->object, 'Id2 in validRecords');
        $this->assertAttributeContains(1, 'invalidRecords', $this->object, 'Id1 correctly identified as invalid');
    }

    /**
     * @test
     */
    public function studentIdentifierTooLong()
    {
        //prep
        $data = [
            [
                'lastName1' => 'smith',
                'firstName1' => 'jill',
                'email1' => 'jill@smith.com',
                'studentIdentifier1' => $this->tooLong,
                'id1' => '200'],
            [ 'lastName2' => 'smit',
                'firstName2' => 'smitty',
                'email2' => 'smitty@jill.com',
                'studentIdentifier2' => '7654321',
                'id2' => '201']
        ];

        $this->loadTestDataIntoRequest($data);

        //call
        $this->object->validateStudents($this->request);

        //check
        $this->assertAttributeContains(2, 'validRecords', $this->object, 'Id2 in validRecords');
        $this->assertAttributeContains(1, 'invalidRecords', $this->object, 'Id1 correctly identified as invalid');

    }

    /**
     * @test
     */
    public function emailInvalid()
    {
        //prep
        $data = [
            [
                'lastName1' => 'smith',
                'firstName1' => 'jill',
                'email1' => 'jill@smithcom',
                'studentIdentifier1' => '12345666',
                'id1' => '200'],
            [ 'lastName2' => 'smit',
                'firstName2' => 'smitty',
                'email2' => 'smitty@jill.com',
                'studentIdentifier2' => '7654321',
                'id2' => '201']
        ];

        $this->loadTestDataIntoRequest($data);

        //call
        $this->object->validateStudents($this->request);

        //check
        $this->assertAttributeContains(2, 'validRecords', $this->object, 'Id2 in validRecords');
        $this->assertAttributeContains(1, 'invalidRecords', $this->object, 'Id1 correctly identified as invalid');
    }



}
