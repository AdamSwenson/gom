/**
 * Created by adam on 8/18/16.
 */


export default class Question {
    constructor( questionIndex ) {
        this.questionIndex = questionIndex;
        this._questionName;
        this._questionNumber;
        this._questionAssignmentId;
        this._maxScore;
    }

    get questionName() {
        return this._questionName;
    }

    get questionNumber() {
        return this._questionNumber ? Number( this._questionNumber ) : null;
    }

    get questionAssignmentId() {
        return this._questionAssignmentId ? Number( this._questionAssignmentId ) : null;
    };

    get maxScore() {
        return this._maxScore ? Number( this._maxScore ) : null;
    };

    set questionName( name ) {
        this._questionName = name;
    }

    set questionNumber( number ) {
        this._questionNumber = number;
    }

    set questionAssignmentId( id ) {
        this._questionAssignmentId = id;
    };

    set maxScore( score ) {
        this._maxScore = score;
    };

    /**
     * Instantiates a question object from the server provided json.
     * Index is optional as long as the json contains a key questionIndex.
     * If both are present, will use the parameter value
     * @param questionJson
     * @returns {Question}
     */
    static factory(questionJson, index){
        if(! questionJson || (! questionJson.questionIndex && ! index) ) throw new Error("no question index given");

        index = index ? index : questionJson.questionIndex;
        let question = new Question(questionJson.questionIndex);
        question.questionName = questionJson.questionName;
        question.questionNumber = questionJson.questionNumber;
        question.questionAssignmentId = questionJson.questionAssignmentId;
        question.maxScore = questionJson.maxScore;
        return question;
    }

}