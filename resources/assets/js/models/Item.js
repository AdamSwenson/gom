/**
 * This is the model which can be either a question
 * or an element.
 * Created by adam on 2/17/17.
 */


import IModel from './IModel';

export default class Item extends IModel
{
    constructor() {
        super();

        /**
         * The db identifier of the model
         */
        this._id;

        /**
         * The locator value
         */
        // this._index;
        this.index

        /** The nickname or title by which this item is identified */
        this.name ="";

        this.text;
        /**
         * The secondary locator value
         * Q1 E2 = index 0, depth 3
         */
        this._depth;

        /**
         * The maximum possible value of the item
         */
        this._maxScore;


        // this.name;

        /**
         * Whether the item is currently set to
         * be appear in pages, emails, or anything
         * else that a student could see.
         *
         * If this value is true, there are some outputs viewable
         * by students, which this appears in.
         *
         * @type {boolean}
         * @private
         */
        this._public = false;

        /**
         * The full length text of the item.
         * This could be the question prompt;
         * a longer description of the element; etc
         */
        // this._text;

        /**
         * The role played by the item
         */
        this._type;

        /**
         * The possible values of this._type
         */
        this.types = [ 'comment', 'element', 'question' ];
    }


    /* *************************** Id *************** */
    /**
     * Alias for _id
     * @returns {*}
     */
    get id() {
        return Number(this._id) || null;
    }

    /**
     * Alias for _id
     */
    set id( v ) {
        this._id = Number(v);
    }


    /* *************************** Index *************** */
    // /**
    //  * The locator for the item
    //  * @returns {*}
    //  */
    // get index() {
    //     return this._index;
    // }
    //
    // /**
    //  * The locator for the item
    //  * @param v
    //  */
    // set index( v ) {
    //     this._index = v;
    // }
    //

    /* *************************** Max score *************** */
    get maxScore() {
        return this._maxScore ? Number( this._maxScore ) : null;
    };

    set maxScore( score ) {
        this._maxScore = score;
    };


    /* *************************** Public *************** */
    /**
     * Getter for whether this can currently appear in student-viewable outputs
     * @returns {boolean|*}
     */
    isPublic() {
        return this._public;
    }

    /**
     * Makes able to appear in student-viewable outputs
     */
    makePublic() {
        this._public = true;
    }

    /**
     * Makes no longer visible to students
     */
    hide() {
        this._public = false;
    }

    togglePublic() {
        console.log( 'Item', 'CALLED', 'togglePublic', this._public );
        this._public = !this._public;
        console.log( this._public );
    }


    /* *************************** Type *************** */
    get type() {
        return this._type;
    }


    // /* *************************** Text *************** */
    // /**
    //  * The full length text of the item.
    //  * @returns {*}
    //  */
    // get text() {
    //     return this._text;
    // }
    //
    // /**
    //  * The full length text of the item.
    //  * @param v
    //  */
    // set text( v ) {
    //     this._text = v;
    // }
    //

    /* *************************** Name *************** */
    // /**
    //  * The nickname or title by which this item is identified
    //  * @returns {*}
    //  */
    // get name() {
    //     return this._name;
    // }
    //
    // /**
    //  * The nickname or title by which this item is identified
    //  * @param v
    //  */
    // set name( v ) {
    //     this._name = v;
    // }
    //


    /**
     * Returns a list of fields which may
     * be used to look up an exam from the store
     */
    static identifiers() {
        return [
            'id',
            'index'
        ]
    }


    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'id',
            'index',
            'name',
            'text',
            'maxScore'
        ];
    }

    static get aliasMap() {
        return {
            ItemId: 'id',
            ItemIndex: 'index'
        };

    }


    static factory( params ) {
        let obj = new Item();
        return this.fillObject( obj, params );
    }
}
