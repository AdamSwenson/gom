/**
 * Created by adam on 8/15/16.
 */
import Comment from './Comment';
import Item from './Item';

export default class Exam extends Item {


    /**
     * Create a new exam object
     * @param params
     */
    constructor( ...params ) {
        super();
       Comment.initializeComments(this);
        /**
         * The db identifier of the model
         */
     //   this.id = -1;


        /**
         * The average number of seconds spent grading a
         * student's exam
         */
        this.averageGradingSeconds;

        this.description;

        // this._name; // = name;

        this.kind = 'exam';

        /**
         * The total number of students associated with the exam and thus
         * the total number of exams to be graded
         * */
        this.numberStudents;

        /**
         * The number of students who have been graded
         */
        this.numberGraded;

        this.publicName;

        /**
         * The total number of seconds spent grading
         * the exam
         */
        this.totalGradingSeconds;

        /** The sort of graded thing to call this. E.g., exam, quiz, paper... */
        this.family;


        this.year; // = year;
        this.term;// = term;

        if ( params.length > 0 ) {
            //fill in from params
        }
    };

    // get idx (){return  [ 0,  0];}


    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'averageGradingSeconds',
            'description',
            'id',
            'maxPossibleScore',
            'name',
            'numberStudents',
            'numberGraded',
            'publicName',
            'term',
            'totalGradingSeconds',
            'family',
            'year'
        ].concat(super.fillableProps);
    };


    /* *************************** Id *************** */
    /**
     * Some things like to call the database id
     * this when they ask for the property. So
     * we oblige them with a nice alias.
     */
    get examId() {
        if ( typeof this.id == 'undefined' ) {
            return null;
        }
        return this.id;
    }

    set examId( v ) {
        this.id = v;
    }

    /* *************************** Index ************* */
    /**
     * Returns the examIndex
     * This used to be the main identifier with which the exam
     * was looked up in store.exams.
     * todo add sanitization
     * @returns {*}
     */
    get examIndex() {
        if ( typeof this.index == 'undefined' ) {
            return null;
        }
        return this.index;

    }

    /* ************************** Stats ************** */

    /**
     * The number of student exams which have not been graded
     * @returns {*}
     */
    get numberRemaining() {
        if ( _.isInteger( this.numberStudents ) && _.isInteger( this.numberGraded ) ) {
            return this.numberStudents - this.numberGraded;
        }
    }

    /**
     * The estimated amount of seconds required to
     * finish grading all student exams
     */
    get estimatedGradingTimeRemaining(){
        return this.numberRemaining * this.averageGradingSeconds;

        if ( _.isInteger( this.averageGradingSeconds ) && _.isInteger( this.numberRemaining ) ) {
            return this.numberRemaining * this.averageGradingSeconds;
        }
    }


    /* *************************** Props ************* */

    //
    // get year(){ return this._year; }
    // set year(v){ this._year = v; }
    //
    // get term(){ return this._term; }
    // set term(v){ this._term = v; }

    isNew() {
        return this.id === -1;
    }

    isExam(){
        return true;
    }


    /**
     * Returns a list of fields which may
     * be used to look up an exam from the store
     */
    static examIdentifiers() {
        return [
            'examId',
            'examIndex'
        ]
    }


    /**
     * This is used by the api module to determine what
     * requests to send to the server
     * @returns {string}
     */
    static className() {
        return 'exam';
    }


    static get aliasMap() {
        return {
            public_name : 'publicName'
            // examId: 'id',
            // examIndex: 'index'
        };

    }


    static factory( params ) {
        let exam = new Exam();
        // we will still return an empty exam if there
        // were no parameters
        return this.fillObject(exam, params, Exam.aliasMap);
    }


}