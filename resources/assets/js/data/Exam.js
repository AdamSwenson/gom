/**
 * Created by adam on 8/15/16.
 */


export default class Exam{

    constructor(examId){
        this.id = examId;
        this.examId = examId;
    }

    static checkIfExam( obj ) {
        //received payload object case
        if ( obj instanceof Exam ) return true;

        if ( obj.kind === 'exam' ) return true;

        return false;
    }


}