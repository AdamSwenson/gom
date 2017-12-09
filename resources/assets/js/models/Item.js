/**
 * This is the model which can be either a question
 * or an element.
 * Created by adam on 2/17/17.
 */

import Comment from './Comment';

import IModel from './IModel';


const separator = '-';
const REQUEST_VERSION = 1;
const ID_WAIT_TIMEOUT = 5000;
const POLL_TIMEOUT = 100;


export default class Item extends IModel {

    constructor() {
        super();

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

        /**
         * The maximum possible value of the item
         */
        this.maxScore;

        /** The nickname or title by which this item is identified */
        this.name;


        /**
         * The secondary locator value
         * Q1 E2 = index 0, depth 3
         */
        this.depth = 0;

        // this.number = null;

        /**
         * The full length text of the item.
         * This could be the question prompt;
         * a longer description of the element; etc
         */
        this.text = '';

        this.publicName;

        this.tags = [];

    }


    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'displayText',
            'name',
            'commentText',
            'text',
            'tags',
            //for exam

        ].concat( super.fillableProps );
    };

    /**
     * These are the properties which get copied when we
     * clone an item
     * @returns {Array.<string>}
     */
    static get clonableProps() {
        return [
            'displayText',
            'name',
            'commentText',
            'text',
            'tags'
        ];
    };


    // /**
    //  * Returns the next serial number.
    //  * The first time this is called, it will return 1
    //  * The actual value doesn't matter, only its uniqueness.
    //  * @returns {number}
    //  */
    // static makeSerialNumber() {
    //     if ( !Item.makeSerialNumber.count ) Item.makeSerialNumber.count = 0;
    //     Item.makeSerialNumber.count += 1;
    //     return Item.makeSerialNumber.count;
    // }


    get idx() {
        return this.idxStore.split( separator );
    } //[ this.index,  this.depth];}

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

    /**
     * Tells whether the item has a valid id and thus can
     * be synced with the server.
     * @returns {boolean}
     */
    canSync() {
        if ( this.id >= 0 ) return true;
        return false;
    }


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

    getEmptyComments() {
        let out = [];
        for (let [ valence, comment ] of this.comments.entries()) {
            if ( comment.isEmpty() ) out.push( comment );
        }
        return out;
    }

    /**
     * Whether all comments for the item are empty;
     */
    get isEveryCommentEmpty (  ) {
        return _.size(this.getEmptyComments()) === _.size(Comment.valences);
    }


    /**
     * When loading comments into an item
     * from ajax or on page load, use this
     * to do it.
     *
     * @param jsonComments
     */
    loadCommentsFromJson( jsonComments ) {
        if ( Object.keys( jsonComments ).length > 0 ) {
            var me = this;
            _.forEach( jsonComments, ( row ) => {
                let comment = Comment.factory( row );
                comment.text = row.body;
                me.addComment( comment.valence, comment );
            } );
        }
    }



    //----------------- ordering
    promote() {
        if ( this.depth > 0 ) {
            this.depth -= 1;
        }
    }

    demote() {
        this.depth += 1;
    }

    static setExamId( id ) {
        Item.examId = id;
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
            // ItemId: 'id',
            // ItemIndex: 'index',
            questionName: 'name',
            questionText: 'text',
            max_score: 'maxScore'
        };

    }


    static factory( params ) {
        let obj = new Item();
        return this.fillObject( obj, params, Item.aliasMap );
    }


    static checkIfItem( obj ) {
        //received payload object case
        if ( obj instanceof Item ) return true;

        if ( obj.kind === 'item' ) return true;

        return false;
    }

}
