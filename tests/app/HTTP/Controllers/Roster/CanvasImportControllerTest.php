<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 2019-03-30
 * Time: 14:32
 */

namespace App\Http\Controllers\Roster;


class CanvasImportControllerTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new CanvasImportController;
    }

    public function testProcessLinks()
    {
//        $incoming = '<https://canvas.csun.edu/api/v1/courses/67531/users?page=1&per_page=50>; rel="current",<https://canvas.csun.edu/api/v1/courses/67531/users?page=2&per_page=50>; rel="next", <https://canvas.csun.edu/api/v1/courses/67531/users?page=1&per_page=50>; rel="first", <https://canvas.csun.edu/api/v1/courses/67531/users?page=3&per_page=50>; rel="last"';

        $incoming = '<https://canvas.csun.edu/api/v1/courses/67531/users?page=1&per_page=50>; rel="current",<https://canvas.csun.edu/api/v1/courses/67531/users?page=2&per_page=50>; rel="next",<https://canvas.csun.edu/api/v1/courses/67531/users?page=1&per_page=50>; rel="first",<https://canvas.csun.edu/api/v1/courses/67531/users?page=3&per_page=50>; rel="last"';
        $expect = [
            "current" => 'https://canvas.csun.edu/api/v1/courses/67531/users?page=1&per_page=50',
            "next" => 'https://canvas.csun.edu/api/v1/courses/67531/users?page=2&per_page=50',
            'first' => 'https://canvas.csun.edu/api/v1/courses/67531/users?page=1&per_page=50',
            "last" => 'https://canvas.csun.edu/api/v1/courses/67531/users?page=3&per_page=50'
        ];

        $r = $this->object->processLinks($incoming);

        foreach ( $expect as $k => $v ) {
            $this->assertArrayHasKey($k, $r);
            $this->assertEquals($v, $r[$k]);
        }

    }

}
