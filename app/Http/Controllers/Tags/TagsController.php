<?php

namespace App\Http\Controllers\Tags;

use App\Exam;
use App\Http\Requests\TagRequest;
use App\Item;
use App\Models\NewGom\Tag;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;

class TagsController extends Controller
{

    public $loadWithList = ['exams', 'items', 'students'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tag::with($this->loadWithList)->get();
    }

    /**
     * @param TagRequest $request
     * @return Tag
     */
    public function store( TagRequest $request )
    {
        $tag = new Tag();
        $tag->name = $request->input('name');
        $tag->text = $request->input('text');
        $tag->props = $request->input('props');
        $tag->save();

        return $tag;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Exam $exam
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function associateTagWithExam( Exam $exam, Tag $tag )
    {
        $tagId = $tag->id;
        $exam->tags()->attach($tagId);
        $exam->save();

        return $this->sendAjaxSuccess();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Exam $exam
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function disassociateTagFromExam( Exam $exam, Tag $tag )
    {
        $exam->tags()->detach($tag->id);
        $exam->save();

        return $this->sendAjaxSuccess();
    }


    /**
     * Create a relationship between an item and a tag
     *
     * @param Item $item
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function associateTagWithItem( Item $item, Tag $tag )
    {
        try {
            $item->tags()->attach($tag->id);
            $item->save();

            return $this->sendAjaxSuccess();
        } catch (Exception $e) {
            return $this->sendAjaxFailure();
        }

    }

    /**
     * Remove the relationship between an item and a tag
     *
     * @param Item $item
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function disassociateTagFromItem( Item $item, Tag $tag )
    {
        $item->tags()->detach($tag->id);
        $item->save();

        return $this->sendAjaxSuccess();
    }

    /**
     * Create a relationship between a student and a tag
     *
     * @param Student $student
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function associateTagWithStudent( Student $student, Tag $tag )
    {

        $student->tags()->attach($tag->id);
        $student->save();

        return $this->sendAjaxSuccess();
    }


    /**
     * Remove a relationship between a student and a tag
     *
     * @param Student $student
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function disassociateTagFromStudent( Student $student, Tag $tag )
    {
        $student->tags()->detach($tag);
        $student->save();

        return $this->sendAjaxSuccess();
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        if ( $id instanceof Tag ) $id = $id->id;
        $t = Tag::find($id)->with($this->loadWithList)->get();
        return $t;
    }

    public function showForExam( Exam $exam )
    {
        return $exam->tags()->with($this->loadWithList)->get();

    }

    public function showForItem( Item $item )
    {
        return $item->tags()->with($this->loadWithList)->get();
    }

    public function showForStudent( Student $student )
    {
        return $student->tags()->with($this->loadWithList)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Tag $tag
     * @param TagRequest|Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update( Tag $tag, TagRequest $request )
    {
        $tag->name = $request->input('name');
        $tag->text = $request->input('text');
        $tag->props = $request->input('props');
        $tag->save();

        return $this->sendAjaxSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        Tag::destroy($id);
        return $this->sendAjaxSuccess();
    }
}
