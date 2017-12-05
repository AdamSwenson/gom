import IModel from './IModel';


export default class GradeAssignment extends IModel {

    constructor() {
        super();

        this.id;
        this.displayValue;
        this.calcValue
        this.minScore;
    }

    static get letterGrades() {
        return [
            'A+',
            'A',
            'A-',
            'B+',
            'B',
            'B-',
            'C+',
            'C',
            'C-',
            'D+',
            'D',
            'D-',
            'F',
        ];
    }

    /** @var array The standardized grades and various associated values in descending order */
    static get defaults() {
        return [
            { displayValue: 'A+', calcValue: 98, minScore: 97 },
            { displayValue: 'A', calcValue: 95, minScore: 93 },
            { displayValue: 'A-', calcValue: 92, minScore: 90 },
            { displayValue: 'B+', calcValue: 88, minScore: 87 },
            { displayValue: 'B', calcValue: 85, minScore: 83 },
            { displayValue: 'B-', calcValue: 82, minScore: 80 },
            { displayValue: 'C+', calcValue: 78, minScore: 77 },
            { displayValue: 'C', calcValue: 75, minScore: 73 },
            { displayValue: 'C-', calcValue: 72, minScore: 70 },
            { displayValue: 'D+', calcValue: 68, minScore: 67 },
            { displayValue: 'D', calcValue: 65, minScore: 63 },
            { displayValue: 'D-', calcValue: 62, minScore: 60 },
            { displayValue: 'F', calcValue: 55, minScore: 50 }
        ];

    }

    /**
     * Creates the initial state of the store.gradeAssignments
     * @returns {{}}
     */
    static initialize() {
        let g = {};
        _.forEach( GradeAssignment.defaults, function ( grade ) {
            g[ grade.displayValue ] = GradeAssignment.factory( {
                displayValue : grade.displayValue,
                calcValue: grade.calcValue,
                minScore: grade.minScore
            } );
        } );
        return g;
    }

    /**
     * When given the maximum possible score
     * @param letterGrade
     * @param maxPossible
     */
    static getDefaultMinScore( letterGrade, maxPossible ) {

    }


    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'id',
            'displayValue', //the string value of the grade
            'calcValue',
            'minScore'
        ];

    }

    /**
     * This is used by the api module to determine what
     * requests to send to the server
     * @returns {string}
     */
    static className() {
        return 'letterGrade';
    }


    static factory( params ) {
        let obj = new GradeAssignment();
        return this.fillObject( obj, params, {} );
    }
}