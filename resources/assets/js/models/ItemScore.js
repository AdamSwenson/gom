import IModel from "./IModel";
import Item from "./Item";


export default class ItemScore  {
    constructor( ) {
        this.examId;
        this.itemId;
        this.studentId;
        this.score = null;
        this.commentText;
        this.isCustomText = false;
    }


    static get fillableProps() {
        return [
            'examId',
            'itemId',
            'studentId',
            'score',
            'commentText',
            'isCustomText'
        ];
    }

    static factory( params ) {
        let p = new ItemScore();
        if ( typeof params !== 'undefined' ) {

            //fill any fillable values
            ItemScore.fillableProps.forEach( function ( v ) {
                if ( typeof params[ v ] !== 'undefined' ) {
                    p[ v ] = params[ v ];
                }
            } );

        }
        return p;
    }

}