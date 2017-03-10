/**
 * Created by adam on 8/18/16.
 */

/**
 * Model for questions
 */

// import IModel from './IModel';
import Item from './Item';

export default class Question extends Item{
    constructor( questionIndex ) {
        super();
        this.questionIndex = questionIndex;
        this._questionName;
        this._questionNumber;
        this._questionAssignmentId;
    }


    /* *************************** Id *************** */
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


    /**
     * Instantiates a question object from the server provided json.
     *
     * @param questionJson
     * @returns {Question}
     */
    static factory( params ) {
        let obj = new Question();
        //we will still return an empty object if there
        //were no parameters
        return this.fillObject(obj, params);

    }

}