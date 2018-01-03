import IModel from "./IModel";
import Item from "./Item";


/**
 * Statistical summary properties of an item
 */
export default class ItemStat  {
    constructor( ) {
        this.exam;
        this.item;
        this.kumiIds = [];
        this.mean;
        this.standardDeviation;
        this.minScore;
        this.maxScore;
        this.median;
    }


    static get fillableProps() {
        return [
        'exam',
        'item',
        'kumiIds',
        'mean',
        'standardDeviation',
        'minScore',
        'maxScore',
        'median',
        ];
    }

    static factory( params ) {
        let p = new ItemStat();
        if ( typeof params !== 'undefined' ) {

            //fill any fillable values
            ItemStat.fillableProps.forEach( function ( v ) {
                if ( typeof params[ v ] !== 'undefined' ) {
                    p[ v ] = params[ v ];
                }
            } );

        }
        return p;
    }

}