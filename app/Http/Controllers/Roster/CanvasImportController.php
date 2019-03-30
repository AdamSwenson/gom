<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/23/18
 * Time: 5:27 PM
 */

namespace App\Http\Controllers\Roster;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PhpSpec\Exception\Exception;

class CanvasImportController extends Controller
{
    public $baseRoute = 'https://canvas.csun.edu/api/v1/courses/';

    public $canvasVerbs = [
    ];

    protected $students = [];

//
//    public function importStudents( Request $request )
//    {
//        $verb = 'search_users';
//        $courseId = $request->courseId;
//        $apiKey = $request->apiKey;
//        $route = $this->makeCanvasRequestUrl($courseId, $apiKey, $verb);
//
//        $client = new Client();
//        $params = ['headers' => ['Authorization' => 'Bearer ' . $apiKey]];
//        $res = $client->request('GET', $route, $params);
//
//        //todo check for error
//
//        return response($res->getBody());
//
////todo return error
//
//    }

    protected function makeCanvasRequestUrl( $courseId, $verb, $page = 0 )
    {
        if ( $page === 0 ) {
            return $this->baseRoute . $courseId . '/' . $verb . "?per_page=50";
        }

        //if paginated
        return $this->baseRoute . $courseId . '/' . $verb . "?page=" . $page . "&per_page=50";
    }

    /**
     * Extracts the paginated links from concatenated string
     * returned in the response headers
     * @param $links Concatenated string from $response->getHeader('Link')[0]
     * @return array
     */
    public function processLinks( $links )
    {
        $processed = [];
        //its presently a long string
        //so extract an array
        $links = explode(',', $links);
        //now we need to extract the data
        //each entry looks like this
        // "<https://canvas.csun.edu/api/v1/courses/67531/users?page=3&per_page=50>; rel="last""
        foreach ( $links as $link ) {
            //figure out what it is; this will be the key
            $l = explode(';', $link);
            $rel = str_replace('rel="', '', trim($l[1]));
            $rel = str_replace('"', '', $rel);

            //process the url
            $url = str_replace('<', '', trim($l[0]));
            $url = str_replace('>', '', $url);

            $processed[$rel] = $url;
        }
        return $processed;

    }

    /**
     * Given a Guzzle response from canvas, this
     * pushes all the student objects into the students array
     * @param $response
     */
    public function extractStudentsFromResponse( $response )
    {
        $j = json_decode($response->getBody());
        foreach ( $j as $s ) {
            array_push($this->students, $s);
        };
    }

    public function importStudents( Request $request )
    {
        $courseId = $request->courseId;
        $apiKey = $request->apiKey;
        $params = ['headers' => ['Authorization' => 'Bearer ' . $apiKey]];
//        $verb = 'search_users';
        $verb = 'users';
        $client = new Client();

        try {
            //make the initial request
            $route = $this->makeCanvasRequestUrl($courseId, $verb);

            $res = $client->request('GET', $route, $params);

            //grab the students
            $this->extractStudentsFromResponse($res);

            //Extract the pagination links
            $links = $res->getHeader('Link')[0];
            $links = $this->processLinks($links);

            //Follow the 'next' url for more students
            while ($links['current'] !== $links['last']) {
                $res = $client->request('GET', $links['next'], $params);
                //grab the students
                $this->extractStudentsFromResponse($res);

                //Extract the pagination links
                $links = $res->getHeader('Link')[0];
                $links = $this->processLinks($links);
            }

            //we're done; we've gone through all the links
            return response($this->students);

        } catch (Exception $e) {
            //todo set up error handling
            echo $e;
        }

    }

}