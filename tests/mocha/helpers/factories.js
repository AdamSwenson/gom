// import { factories } from "../../spec/helpers/vuex.spec.helpers";

const faker = require( 'faker' );
import GradeAssignment from "../../../resources/assets/js/models/GradeAssignment";
import Kumi from "../../../resources/assets/js/models/Kumi";
import Question from "../../../resources/assets/js/models/Question";
import Item from "../../../resources/assets/js/models/Item";
import Student from "../../../resources/assets/js/models/Student";
import ItemScore from "../../../resources/assets/js/models/ItemScore";
import Exam from "../../../resources/assets/js/models/Exam";


// Factories

export const makeGradeFrequencyObject = () => {
    let testFreqs = {};
    _.forEach( GradeAssignment.defaults, function ( ga ) {
        testFreqs[ ga.displayValue ] = faker.random.number();
    } );
    return testFreqs;
};


export const makeScoreListServerResponse = () => {
    return [ {
        "examId": 5,
        "itemId": 7,
        "score": 590.86,
        "kumis": [ {
            "id": 5,
            "user_id": 1,
            "year": 1989,
            "name": "Facere id dolorum eligendi.",
            "created_at": "2017-11-10 09:57:28",
            "updated_at": "2017-11-10 09:57:28",
            "pivot": {
                "student_id": 104,
                "kumi_id": 5,
                "created_at": "2017-11-10 09:57:28",
                "updated_at": "2017-11-10 09:57:28"
            }
        } ]
    }, {
        "examId": 5,
        "itemId": 7,
        "score": 537.06,
        "kumis": [ {
            "id": 5,
            "user_id": 1,
            "year": 1989,
            "name": "Facere id dolorum eligendi.",
            "created_at": "2017-11-10 09:57:28",
            "updated_at": "2017-11-10 09:57:28",
            "pivot": {
                "student_id": 103,
                "kumi_id": 5,
                "created_at": "2017-11-10 09:57:28",
                "updated_at": "2017-11-10 09:57:28"
            }
        } ]
    }, {
        "examId": 5,
        "itemId": 7,
        "score": 139.18,
        "kumis": [ {
            "id": 4,
            "user_id": 1,
            "year": 1988,
            "name": "Eum est ab eum sed.",
            "created_at": "2017-11-10 09:57:28",
            "updated_at": "2017-11-10 09:57:28",
            "pivot": {
                "student_id": 101,
                "kumi_id": 4,
                "created_at": "2017-11-10 09:57:28",
                "updated_at": "2017-11-10 09:57:28"
            }
        } ]
    }, {
        "examId": 5,
        "itemId": 7,
        "score": 60.47,
        "kumis": [ {
            "id": 4,
            "user_id": 1,
            "year": 1988,
            "name": "Eum est ab eum sed.",
            "created_at": "2017-11-10 09:57:28",
            "updated_at": "2017-11-10 09:57:28",
            "pivot": {
                "student_id": 102,
                "kumi_id": 4,
                "created_at": "2017-11-10 09:57:28",
                "updated_at": "2017-11-10 09:57:28"
            }
        } ]
    } ];

};


export const makeKumis = ( number ) => {
    let kumis = [];
    for (let i = 0; i < number; i++) {
        kumis.push( Kumi.factory( { name: faker.company.bs(), id: faker.random.number() } ) );
    }
    return kumis;
}


/**
 * Returns an Exam instance with random id and index
 * @returns {Exam}
 */
export const examFactory = ( index ) => {
    let idx = typeof index != 'undefined' ? index : faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );

    let e = new Exam();
    e.id = faker.random.number();
    e.index = idx;
    e.name = faker.company.bsNoun();
    e.year = 2013;
    e.term = faker.company.bs();
    return e;
};


export const itemFactory = ( index ) => {
    let idx = typeof index != 'undefined' ? index : faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );

    let e = new Item();
    e.id = faker.random.number();
    e.index = idx;
    e.name = faker.company.bsNoun();
    e.text = faker.company.bsNoun();
    e.maxScore = faker.random.number();
    return e;
};

export const itemScoreFactory = ( exam, item, student, score ) => {
    let e = new ItemScore();
    e.itemId = _.isUndefined( item ) ? faker.random.number() : item.id;
    e.examId = _.isUndefined( exam ) ? faker.random.number() : item.id;
    e.studentId = _.isUndefined( student ) ? faker.random.number() : student.id;
    e.score = _.isUndefined(score) ? faker.random.number(): score;
    e.text = faker.company.bs();
    return e;
};

export const studentFactory = ( index ) => {
    let s = new Student( faker.random.number() );
    s.email = faker.internet.email();
    s.studentIndex = index ? index : faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    s.studentIdentifier = faker.random.number();
    s.lastName = faker.name.lastName();
    s.firstName = faker.name.firstName();
    return s;
};

export const questionFactory = ( index ) => {
    let question = new Question( index );
    question.questionName = faker.hacker.phrase();
    question.questionNumber = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    question.questionAssignmentId = faker.random.number();
    question.maxScore = faker.random.number();
    question.content = faker.hacker.phrase();
    return question;
};


// /