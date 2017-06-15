<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemAssignment
 * This is the generic form of Question and Element assignments
 * Each assignment associates:
 *      - an exam as root
 *      - a target (child) item
 *      - a parent item
 *      - the position of the child under the parent
 *
 * So
 * @package App
 */
class ItemAssignment extends Model
{
    //
}
