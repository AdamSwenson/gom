/**
 * Created by adam on 1/23/17.
 */

// import Comment from './Comment';

export default class IModel {

    constructor() {

        // this.idx;


        /**
         * The stored order of the item overall
         */
        this.index;

        /** The nickname or title by which this item is identified */
        this.name;

        // this.number = null;

        /**
         * The full length text of the item.
         * This could be the question prompt;
         * a longer description of the element; etc
         */
        this.text = '';

        this.publicName;


        /**
         * The maximum possible value of the item
         */
        this.maxScore;

        this.kind;


        /**
         * The secondary locator value
         * Q1 E2 = index 0, depth 3
         */
        this.depth = 0;


    }


    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'idx',
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

    /**
     * The possible values of this._type
     */
    static get types() {

        return [ 'comment', 'element', 'question' ];
    }

    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get valences() {
        return [
            'stock',
            'absent',
            'poor',
            'good',
            'excellent'
        ];
    }

    /**
     * Iterate over the provided parameters and set the properties of the
     * object.
     * @param obj
     * @param params
     * @returns {*}
     */
    static fillObject( obj, params ) {
        if ( typeof params !== 'undefined' ) {
            let fillableProps = this.fillableProps;
            //fill any fillable values
            fillableProps.forEach(function ( v ) {
                    // console.log( 'params', params, v );
                    if ( typeof params[ v ] != 'undefined' ) {
                        obj[ v ] = params[ v ];
                    }
                }
            )

            //fill any aliased values
            for (let v in this.aliasMap) {
                if ( typeof params[ v ] != 'undefined' ) {
                    // console.log( 'alias', v, map[v] );
                    obj[ this.aliasMap[ v ] ] = params[ v ];
                }
            }
        }

        //we will still return the empty obj if there
        //were no parameters
        return obj;
    }

    //
    // /* *************************** Id *************** */
    // /**
    //  * Alias for _id
    //  * @returns {*}
    //  */
    // get id() {
    //     return Number( this._id ) || null;
    // }
    //
    // /**
    //  * Alias for _id
    //  */
    // set id( v ) {
    //     this._id = Number( v );
    // }


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
}