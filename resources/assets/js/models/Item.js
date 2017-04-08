/**
 * This is the model which can be either a question
 * or an element.
 * Created by adam on 2/17/17.
 */

import Comment from './Comment';
import IModel from './IModel';

export default class Item extends IModel {

    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [

        ].concat(super.fillableProps);
    };

    constructor() {

        super();
        /**
         * The db identifier of the model
         */
        this.id = -1;

        Comment.initializeComments(this);

        // this.idx = [ this.index,  this.depth];

        this.kind = 'item';

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
        this.publicity = false;

        /** The DB question assignment id or elementAssignmentId if applicable */
        this.assignmentId = -1;

        //The id of the exam the item is associated with
        this.examId = -1;


        // this.props = super.fillableProps;
    }

    get idx (){return  [ this.index,  this.depth];}


    isNew() {
        return this.id === -1;
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
        return this.publicity;
    }

    /**
     * Makes able to appear in student-viewable outputs
     */
    makePublic() {
        this.publicity = true;
    }

    /**
     * Makes no longer visible to students
     */
    hide() {
        this.publicity = false;
    }

    togglePublic() {
        // console.log('Item', 'CALLED', 'togglePublic', this._public);
        this.publicity = !this.publicity;
        // console.log(this._public);
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



    static get aliasMap() {
        return {
            ItemId: 'id',
            ItemIndex: 'index',
            questionName : 'name',
            questionText : 'text'
        };

    }


    static factory( params ) {
        let obj = new Item();
        return this.fillObject(obj, params, Item.aliasMap);
    }
}
