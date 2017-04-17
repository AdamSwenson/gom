/**
 * This is the model which can be either a question
 * or an element.
 * Created by adam on 2/17/17.
 */

import Comment from './Comment';
import IModel from './IModel';


const separator = '-';

export default class Item extends IModel {

    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [].concat( super.fillableProps );
    };

    constructor() {

        super();

        this.idxStore = '';

        /**
         * The db identifier of the model
         */
        this.id = -1;

        Comment.initializeComments( this );

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

        this.children = [];
        // this.props = super.fillableProps;
    }

    set idx( index ) {
        this.idxStore = Item.buildKeyFromIdx( index );

    }

    /**
     * Take either a string or array input and convert
     * it into the key used to store ordering.
     * Returns the key.
     * @param index
     */
    static buildKeyFromIdx( index ) {
        //if it is a string of the proper form
        //use that.
        if ( _.isString( index ) && index.length > 1 && index[ 1 ] === separator ) {
            return index;
        }

        //we need to do something different
        //because it is an array
        if ( _.isArray( index ) ) {
            return index.join( separator );
        }
    }

    get idx() {

        return this.idxStore.split( separator );
    } //[ this.index,  this.depth];}


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
        this.comments.set( valence, comment );
    }

    getStockComment() {
        return this.getComment( 'stock' );
    }

    getComment( valence ) {
        return this.comments.get( valence );
    }

    promote() {
        if ( this.depth > 0 ) {
            this.depth -= 1;
        }

    }

    demote() {
        this.depth += 1;
    }


    /**
     * Returns the relationship (if any) of the item represented by
     * idx1 and the item represented by idx2
     * @param idx
     */
    static findRelationship( idx1, idx2 ) {
        const relationships = [ 'none', 'parent', 'child', 'sibling' ];
        //to figure this out, we first make them into arrays
        idx1 = _.isArray( idx1 ) ? idx1.split( separator ) : [];
        idx2 = _.isArray( idx2 ) ? idx2.split( separator ) : [];

        if ( idx1.length > 0 && idx2.length > 0 ) {
            //if either is empty, we're done
            return 'none';
        }

        if ( idx1[ 0 ] !== idx2[ 0 ] ) {
            //if the first value is not the same,
            //they have no relationship
            return 'none';
        }

        //two items are siblings if their idx's are the same
        //except for the final value
        //so they must have the same length
        if ( idx1.length === idx2.length ) {
            //and then all but the last item must be the same
            if ( idx1.slice( idx1.length - 1 ) === idx2.slice( idx2.length - 1 ) ) {
                //and finally the last value must differ
                //(otherwise it is in a parent child relationship)
                if ( _.takeRight( idx1 ) != _.takeRight( idx2 ) ) {
                    return 'sibling';
                }
            }
        }

        //So at this point, we know that they have different lengths and
        // that their first value is the same. That means they stand
        //in a parent child relationship

        if ( idx1.length !== idx2.length ) {

        }


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
            questionName: 'name',
            questionText: 'text',
            max_score: 'maxScore'
        };

    }


    static factory( params ) {
        let obj = new Item();
        return this.fillObject( obj, params, Item.aliasMap );
    }
}
