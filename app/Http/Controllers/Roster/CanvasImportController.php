<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/23/18
 * Time: 5:27 PM
 */

namespace App\Http\Controllers\Roster;

use GuzzleHttp\Client;

use App\Exam;
use App\Http\Requests\KumiRequest;
use App\Kumi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CanvasImportController extends Controller
{
    public $baseRoute = 'https://canvas.csun.edu/api/v1/courses/';

    public $canvasVerbs = [

    ];


    public function importStudents( Request $request )
    {
        $verb = 'search_users';
        $courseId = $request->courseId;
        $apiKey = $request->apiKey;
        $route = $this->makeCanvasRequestUrl($courseId, $apiKey, $verb);

//        ${this.courseId}/search_users?access_token;
        $client = new Client();
        $params = ['headers' => ['Authorization' => 'Bearer ' . $apiKey]];
        $res = $client->request('GET', $route, $params);


        //todo check for error
//        if ( $res->getStatusCode() ) {
//        echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
//        var_dump($res);
        $res->getStatusCode();
        return response($res->getBody());
        // {"type":"User"...'

//        }
//        return response()->json(['error']);

//todo return error

    }

    protected function makeCanvasRequestUrl( $courseId, $apiKey, $verb )
    {
        return $this->baseRoute . $courseId . '/' . $verb . "?per_page=50"; // . "?access_token=" . $apiKey;

    }

}