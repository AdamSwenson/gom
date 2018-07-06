import IModel from "./IModel";
import Item from "./Item";


export default class ItemScore  {
    constructor( ) {
        this.examId;
        this.itemId;
        this.studentId;
        this._score = null;
        this.commentText;
        this.isCustomText = false;
    }

    /**
     * The float score
     * @returns {*}
     */
    get score(){
        if(_.isNull(this._score) || _.isUndefined(this._score)) return this._score;
        return _.toNumber(this._score);
    }

    set score(v){
        this._score = v;
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