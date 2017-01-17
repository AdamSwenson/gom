/**
 * Created by adam on 8/15/16.
 */


export default class Exam {

    /**
     * Create a new exam object
     * @param examId
     * @param examIndex
     */
    constructor( {examId, examIndex} ) {
        this._id;
        this._index;
        this.name;
        this.year;
        this.term;

        //set id if given
        if ( typeof (examId) != 'undefined' ) {
            this._id = examId;
        }

        //set index if given
        if ( typeof (examIndex) != 'undefined' && Number.isInteger(examIndex)) {
            this._index = examIndex;
        }
    };

    /**
     * The database id of the exam
     */
    get id() {
        return this._id;
    };


    /**
     * Some things like to call the database id
     * this when they ask for the property. So
     * we oblige them with a nice alias.
     */
    get examId() {
        return this._id;
    }

    /**
     * Returns the examIndex
     * This used to be the main identifier with which the exam
     * was looked up in store.exams.
     * @returns {*}
     */
    get examIndex() {
        return this._index;
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
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static fillableProps(){
        return [
            'name',
            'year'
        ];
    }

    /**
     * Takes the json exam object received from the server and
     * returns a Exam object
     * @param examJson
     * @returns {Exam}
     */
    static factory( examJson ) {
        let examId = typeof (examJson.examId) != 'undefined'  ? examJson.examId : 'undefined';
        let examIndex = typeof (examJson.examIndex) != 'undefined'  ? examJson.examIndex : 'undefined';

        //instantiate
        let e = new Exam({examId: examId, examIndex: examIndex});

        //fill any fillable values
        [this.fillableProps()].forEach(()=>{
            if(typeof (examJson[this]) != 'undefined' ){
                e[this] = examJson[this];
            }
        });

        return e;
    }

}