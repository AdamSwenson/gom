/**
 * Created by adam on 1/23/17.
 */


export default class IModel {


    /**
     * Iterate over the provided parameters and set the properties of the
     * object.
     * @param obj
     * @param params
     * @returns {*}
     */
    static fillObject( obj, params ) {
        if ( typeof params != 'undefined' ) {

            //fill any fillable values
            this.fillableProps.forEach( function ( v ) {
                    // console.log( 'params', params, v );
                    if ( typeof params[ v ] != 'undefined' ) {
                        obj[ v ] = params[ v ];
                    }
                }
            )

            //fill any aliased values
            for ( let v in this.aliasMap ) {
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
}