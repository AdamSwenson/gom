/**
 * Created by adam on 8/18/16.
 */

/**
 * Model for questions
 */
export default class Question {
    constructor( questionIndex ) {
        this._id;
        this._index;
        this.questionIndex = questionIndex;
        this._questionName;
        this._questionNumber;
        this._questionAssignmentId;
        this._maxScore;
    }


    /* *************************** Id *************** */

    /**
     * Alias for _id
     * @returns {*}
     */
    get id() {
        return this._id;
    }

    /**
     * Alias setter for _id
     * @param v
     */
    set id( v ) {
        this._id = v;
    }
    /**
     * Alias for _id
     * @returns {*}
     */
    get questionId() {
        return this._id;
    }

    /**
     * Alias setter for _id
     * @param v
     */
    set questionId( v ) {
        this._id = v;
    }


    /* *************************** Index ************* */

    /**
     * Alias for _id
     * @returns {*}
     */
    get index() {
        return this._index;
    }

    /**
     * Alias setter for _id
     * @param v
     */
    set index( v ) {
        this._index = v;
    }

    /**
     * Alias for _id
     * @returns {*}
     */
    get questionIndex() {
        return this._index;
    }

    /**
     * Alias for _id
     */
    set questionIndex(v) {
        this._index = v;
    }


    /* *************************** Content ************* */
    get questionName() {
        return this._questionName;
    }
    set questionName( name ) {
        this._questionName = name;
    }

    get questionNumber() {
        return this._questionNumber ? Number( this._questionNumber ) : null;
    }
    set questionNumber( number ) {
        this._questionNumber = number;
    }


    get questionAssignmentId() {
        return this._questionAssignmentId ? Number( this._questionAssignmentId ) : null;
    };

    set questionAssignmentId( id ) {
        this._questionAssignmentId = id;
    };


    get maxScore() {
        return this._maxScore ? Number( this._maxScore ) : null;
    };

    set maxScore( score ) {
        this._maxScore = score;
    };


    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'id',
            'index',
            'content',
            'maxScore',
            'questionName',
            'questionNumber',
            'questionAssignmentId',
        ];
    }

    static get aliasMap() {
        return {
            questionId: 'id',
            questionIndex: 'index'
        };
    }

    static factory( params ) {
        let obj = new Question();

        if ( typeof params != 'undefined' ) {
            //fill any fillable values
            this.fillableProps.forEach( function ( v ) {
                // console.log( 'params', params, v );
                if ( typeof params[ v ] != 'undefined' ) {
                    obj[ v ] = params[ v ];
                }
            } );
            //fill any aliased values
            for ( let v in this.aliasMap ) {
                if ( typeof params[ v ] != 'undefined' ) {
                    // console.log( 'alias', v, map[v] );
                    obj[ this.aliasMap[ v ] ] = params[ v ];
                }
            }
        }
        //we will still return an empty object if there
        //were no parameters
        return obj;
    }
    //
    // /**
    //  * Instantiates a question object from the server provided json.
    //  * Index is optional as long as the json contains a key questionIndex.
    //  * If both are present, will use the parameter value
    //  * @param questionJson
    //  * @returns {Question}
    //  */
    // static factory( questionJson, index ) {
    //     // if(! questionJson || (! questionJson.questionIndex && ! index) ) throw new Error("no question index given");
    //
    //     index = index ? index : questionJson.questionIndex;
    //     let question = new Question( questionJson.questionIndex );
    //     question.questionName = questionJson.questionName;
    //     question.questionNumber = questionJson.questionNumber;
    //     question.questionAssignmentId = questionJson.questionAssignmentId;
    //     question.maxScore = questionJson.maxScore;
    //     return question;
    // }

}