<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/17
 * Time: 3:05 PM
 */

namespace App\Http\Controllers\Item;


use App\Exam;
use App\Kumi;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class KumiControllerTest extends \TestCase
{

    use WithoutMiddleware;

    protected $object;
    protected $exam;
    protected $route = 'dev/kumi';

    public function setUp()
    {
        parent::setUp();

        $this->exam = $exam = factory(Exam::class)->create();
        $this->kumi = factory(Kumi::class)->create();
    }


    public function tearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function index()
    {
        $user = $user = factory(User::class)->create();
        Auth::login($user);
        $numKumis = Factory::create()->numberBetween(1, 100);
        $kumis = factory(Kumi::class, $numKumis)->create();

        //call
        $response = $this->get($this->route);

        //check
        $response->assertStatus(200);
        foreach($kumis as $kumi){
            $response->assertJsonFragment($kumi->toArray(), "Returned json contains the object");

        }
    }

    /** @test */
    public function loadExamKumi( )
    {
        //prep
        $numKumis = Factory::create()->numberBetween(1, 10);
        $kumis = factory(Kumi::class,$numKumis)->create();
        foreach($kumis as $kumi) {
        $this->exam->kumis()->attach($kumi->id);
        }
        $this->exam->save();

        //call
        $route = 'dev/kumi/exam/' . $this->exam->id;
        $response = $this->get($route);

        //check
        $response->assertStatus(200);
        foreach($kumis as $kumi){
            $response->assertJsonFragment($kumi->toArray()); //['nickname' => $kumi->nickname, 'year' => $kumi->year], "Returned json contains the object");
        }
    }


    /** @test */
    public function store_no_exam(  )
    {
        $k = factory(Kumi::class)->make();
            $d = ['nickname' => $k->nickname, 'year' => $k->year];

            //call
        $response = $this->post($this->route, $d);

        //check
        $response->assertStatus(200);
        $this->assertDatabaseHas('kumis', $d);
    }


    /** @test */
    public function store_w_exam(  )
    {
        $k = factory(Kumi::class)->make();
        $dd = ['nickname' => $k->nickname,
            'year' => $k->year
        ];
        $d = $dd + [
            'examId' => $this->exam->id];

        //call
        $response = $this->post($this->route, $d);

        //check
        $response->assertStatus(200);
        $kk = Kumi::where('nickname', $k->nickname)
            ->where('year', $k->year)
            ->first();
        $this->assertNotEmpty($kk);

        $this->assertDatabaseHas('kumis', $dd);

        $this->assertDatabaseHas('exam_kumi', [
            'exam_id' => $this->exam->id,
            'kumi_id' => $kk->id
        ]);
    }

    /** @test */
    public function show( )
    {
        $response = $this->get($this->route . '/'.$this->kumi->id);
        $response->assertStatus(200);
        $response->assertJsonFragment($this->kumi->toArray());

    }

    /** @test */
    public function update()
    {
        $k = factory(Kumi::class)->make();
        $d = ['nickname' => $k->nickname, 'year' => $k->year];
        $id = $this->kumi->id;

        //call
        $route = $this->route . '/' . $id;
        $response = $this->put($route, $d);

        //check
        $response->assertStatus(200);
        $d['id'] = $id;
        $j = Kumi::find($k);
        $this->assertDatabaseHas('kumis', $j->toArray());
    }

    /** @test */
    public function destroy()
    {
        $id = $this->kumi->id;

        //call
        $route = $this->route . '/' . $id;
        $response = $this->delete($route);

        //check
        $response->assertStatus(200);

//        $this->assertEmpty(Kumi::find($id));
//        $this->assertDatabaseMissing('kumis', ['id' => $id]);

    }
}