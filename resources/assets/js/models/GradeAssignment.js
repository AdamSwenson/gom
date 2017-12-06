import IModel from './IModel';


export default class GradeAssignment extends IModel {

    constructor() {
        super();

        /** The id of the grade assignment on the server */
        this.id;

        /** The letter grade or other string display */
        this.displayValue;

        /** The value of the grade used in calculations */
        this.calcValue;

        /** The id of the grade object on the server */
        this.gradeId;

        /** If the grade is part of a user defined group of grades,
         * this identifies the group */
        this.group;

        /** The minimum score required to receive this grade */
        this.minScore;

        /** The correct position in the order of grades */
        this.ordinal;
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
            { displayValue: 'A+', calcValue: 98, minScore: 97 , group: 0, ordinal: 0},
            { displayValue: 'A', calcValue: 95, minScore: 93  , group: 0, ordinal: 1},
            { displayValue: 'A-', calcValue: 92, minScore: 90 , group: 0, ordinal: 2},
            { displayValue: 'B+', calcValue: 88, minScore: 87 , group: 0, ordinal: 3},
            { displayValue: 'B', calcValue: 85, minScore: 83  , group: 0, ordinal: 4},
            { displayValue: 'B-', calcValue: 82, minScore: 80 , group: 0, ordinal: 5},
            { displayValue: 'C+', calcValue: 78, minScore: 77 , group: 0, ordinal: 6},
            { displayValue: 'C', calcValue: 75, minScore: 73  , group: 0, ordinal: 7},
            { displayValue: 'C-', calcValue: 72, minScore: 70 , group: 0, ordinal: 8},
            { displayValue: 'D+', calcValue: 68, minScore: 67 , group: 0, ordinal: 9},
            { displayValue: 'D', calcValue: 65, minScore: 63  , group: 0, ordinal: 10},
            { displayValue: 'D-', calcValue: 62, minScore: 60 , group: 0, ordinal: 11},
            { displayValue: 'F', calcValue: 55, minScore: 50  , group: 0, ordinal: 12}
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
                minScore: grade.minScore,
                group : grade.group,
                ordinal: grade.ordinal
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
            'gradeId',
            'group',
            'minScore',
            'ordinal'
        ];

    }

    /**
     * This is used by the api module to determine what
     * requests to send to the server
     * @returns {string}
     */
    static className() {
        return 'gradeAssignment';
    }


    static factory( params ) {
        let obj = new GradeAssignment();
        return this.fillObject( obj, params, {} );
    }
}