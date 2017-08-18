/**
 * Created by adam on 1/23/17.
 */

// import Comment from './Comment';

export default class IModel {

    constructor() {
        /**
         * Uniquely identifies the token object.
         * Objects are immediately put into the map when
         * created. Thus we need a way of identifying them
         * before the server returns the new object's id.
         * This property provides that value.
         *
         * @type {number}
         */
        this.serialNumber = IModel.makeSerialNumber();

        /**
         * The stored order of the item overall
         */
        this.index;

        this.kind;

    }


    static get styleMap() {
        //making this 1-indexed because
        //some problem arises when trying to
        //retrieve a key of 0
        return {
            1: 'is-primary',
            2: 'is-info',
            3: 'is-warning',
            4: 'is-danger',
            5: 'is-black',
            6: 'is-light',
            7: 'is-success',
            8: 'is-white',
            9: 'is-dark',

        }
    }


    /**
     * Returns the next serial number.
     * The first time this is called, it will return 1
     * The actual value doesn't matter, only its uniqueness.
     * @returns {number}
     */
    static makeSerialNumber() {
        if ( !IModel.makeSerialNumber.count ) IModel.makeSerialNumber.count = 0;
        IModel.makeSerialNumber.count += 1;
        return IModel.makeSerialNumber.count;
    }

    /**
     * Boolean of whether the item is an exam
     * Defaults to false; the exam class which inherits
     * from Item overrides this.
     * @returns {boolean}
     */
    isExam() {
        return false;
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
            'maxScore',
            'publicity',
            'locked',
            'released'
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
     * @param aliasMap
     * @returns {*}
     */
    static fillObject( obj, params, aliasMap ) {
        if ( typeof params !== 'undefined' ) {
            let fillableProps = this.fillableProps;
            //fill any fillable values
            fillableProps.forEach(function ( v ) {
                    // console.log( 'params', params, v );
                    if ( typeof params[ v ] != 'undefined' ) {
                        obj[ v ] = params[ v ];
                    }
                }
            );

            //fill any aliased values
            for (let v in aliasMap) {
                if ( typeof params[ v ] != 'undefined' ) {
                    // window.console.log('IModel', 'fillObject', 116, v);
                    obj[ aliasMap[ v ] ] = params[ v ];
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