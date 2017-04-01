/**
 * This is the model which can be either a question
 * or an element.
 * Created by adam on 2/17/17.
 */

import Comment from './Comment';
import IModel from './IModel';

export default class Item extends IModel {
    constructor() {

        super();

        Comment.initializeComments(this);

        this.publicName;

        /**
         * The maximum possible value of the item
         */
        this.maxScore;

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

        //The id of the exam the item is associated with
        this.examId;


// super.initializeComments();
    }

    /**
     * utility for determining which of the older types
     * this item belongs to
     */
    determineType() {
        return this.depth > 0 ? 'element' : 'question';

    }


    addComment( valence, comment ) {
        // this.comments.push( comment );
        // Vue.set(this.comments, valence, comment );
        this.comments.set(valence, comment);
    }

    getStockComment() {
        return this.getComment('stock');
    }

    getComment( valence ) {
        return this.comments.get(valence);
    }

    promote() {
        if ( this.depth > 0 ) {
            this.depth -= 1;
        }

    }

    demote() {
        this.depth += 1;
    }


    //
    //
    // /* *************************** Max score *************** */
    // get maxScore() {
    //     return this._maxScore ? Number( this._maxScore ) : null;
    // };
    //
    // set maxScore( score ) {
    //     this._maxScore = score;
    // };


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
        console.log('Item', 'CALLED', 'togglePublic', this._public);
        this._public = !this._public;
        console.log(this._public);
    }


    /* *************************** Type *************** */

    /**
     * The role played by the item
     */
    get type() {
        return this.determineType();
    }


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
     * This is used by the api module to determine what
     * requests to send to the server
     * @returns {string}
     */
    static className() {
        return 'item';
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
            'depth',
            'name',
            'publicName',
            'number',
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
        return this.fillObject(obj, params);
    }
}
