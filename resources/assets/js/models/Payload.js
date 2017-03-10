/**
 * This is the common payload which all participating
 * mutations receive
 * Created by adam on 1/17/17.
 */

export default class Payload {
    constructor() {
        //the object's db id
        this._id;
        //the index value of the object
        this._index;

        /**
         * Where there is a compound index (e.g., obj[studentIndex][questionIndex],
         * this holds the child value (i.e., questionIndex)
         */
        this._index2;

        /** The numeric value in the payload */
        this._num;

        /** The object in the payload */
        this._obj;

        /** The string in the payload */
        this._str;

        /** The timestamp in the payload */
        this._stamp;

        this.str;
        this.index;

    }

    /*  ************************* Identifier values ************************* */
    get id() {
        return this._id;
    }

    set id( val ) {
        //todo numeric check
        this._id = val;
    }
    //
    // get index() {
    //     return this._index;
    // }
    //
    // set index( val ) {
    //     //todo numeric check
    //     this._index = val;
    // }

    get index2() {
        return this._index2;
    }

    set index2( val ) {
        //todo numeric check
        this._index2 = val;
    }

    //
    // get complexIndex(){
    //     if(typeof this._index2 != 'undefined'){
    //         return this._index
    //     }
    // }

    /*  ************************* Payload values ************************* */
    get num() {
        return this._num;
    }

    set num( v ) {
        //todo numeric check
        this._num = v;
    }

    get obj() {
        return this._obj;
    }

    set obj( val ) {
        if ( typeof val == 'object' ) {
            this._obj = val;
        }
//todo error handling
    }
    //
    //
    // get str() {
    //     return this._obj;
    // }
    //
    // set str( v ) {
    //     //todo string check
    //     this._str = v;
    // }

    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'id', 'index', 'num', 'obj', 'str', 'stamp'
        ];
    }

    static get aliasMap() {
        return {
            studentId: 'id',
            studentIndex: 'index'
        };

    }


    static factory( params ) {
        let p = new Payload();
        if ( typeof params != 'undefined' ) {

            //fill any fillable values
            this.fillableProps.forEach( function ( v ) {
                if ( typeof params[ v ] != 'undefined' ) {
                    p[ v ] = params[ v ];
                }
            } );

            //fill any aliased values
            for ( let v in this.aliasMap ) {
                if ( typeof params[ v ] != 'undefined' ) {
                    // console.log( 'alias', v, map[v] );
                    p[ this.aliasMap[ v ] ] = params[ v ];
                }
            }
        }
        return p;
    }

    static checkIfPayload( payload ) {
        //received payload object case
        if ( payload instanceof Payload ) {
            return true;
        }
        return false;
        // throw new Exception( "Non Payload passed to a Payload requiring method" );
    }

}