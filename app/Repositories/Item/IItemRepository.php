<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/8/17
 * Time: 7:09 PM
 */

namespace App\Repositories\Item;

use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;


/**
 * Class ItemRepository
 * Helps with the tasks executed by ItemController
 * @package App\Repositories\Item
 */
interface IItemRepository
{
    /**
     * Sets the $type value from the request
     * @param ItemRequest|Request $request
     * @return string
     */
    public function determineItemType( Request $request );

    /**
     * Updates an existing item or creates a new one
     * if none exists from a request object.
     *
     * @param Request $request
     * @return Item
     */
    public function loadItemFromRequest( Request $request );

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createExamFromRequest( Request $request, $id );

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createElementFromRequest( Request $request, $id );

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createQuestionFromRequest( Request $request, $id );
}