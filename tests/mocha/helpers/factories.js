import Tag from "../../../resources/assets/js/models/Tag";

const faker = require( 'faker' );

import Exam from "../../../resources/assets/js/models/Exam";
import Comment from "../../../resources/assets/js/models/Comment";

import GradeAssignment from "../../../resources/assets/js/models/GradeAssignment";
import Item from "../../../resources/assets/js/models/Item";
import ItemScore from "../../../resources/assets/js/models/ItemScore";
import Kumi from "../../../resources/assets/js/models/Kumi";
import Note from "../../../resources/assets/js/models/Note";
import Question from "../../../resources/assets/js/models/Question";
import Student from "../../../resources/assets/js/models/Student";
import Payload from "../../../resources/assets/js/models/Payload";
import * as mTypes from "../../../resources/assets/js/store/mutation-types";


// Factories

/* ------------- Create multiple objects ------------------- */
export const makeItems = ( number ) => {
    let items = [];
    for (let i = 0; i < number; i++) {
        items.push( itemFactory() );
    }
    return items;
}


export const makeKumis = ( number ) => {
    let kumis = [];
    for (let i = 0; i < number; i++) {
        kumis.push( kumiFactory() );
    }
    return kumis;
}

export const makeStudents = ( number ) => {
    let students = [];
    for (let i = 0; i < number; i++) {
        students.push( studentFactory() );
    }
    return students;
}

export const makeTags = ( number ) => {
    let tags = [];
    for (let i = 0; i < number; i++) {
        tags.push( tagFactory() );
    }
    return tags;
}


/* ------------- Factories ------------------- */
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

export const commentFactory = ( id, index, text, valence ) => {
    let e = new Comment();
    e.id = _.isUndefined( id ) ? faker.random.number() : id;
    e.index = _.isUndefined( index ) ? faker.random.number() : index;
    e.text = _.isUndefined( text ) ? faker.company.bs() : text;
    e.valence = _.isUndefined( valence ) ? faker.random.arrayElement( Comment.valences ) : valence;
    return e;
}

export const kumiFactory = ( name, id ) => {
    name = _.isUndefined( name ) ? faker.company.bs() : name;
    id = _.isUndefined( id ) ? faker.random.number() : id;
    return Kumi.factory( { name, id } )
};

export const itemFactory = ( index ) => {
    let idx = typeof index != 'undefined' ? index : faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );

    let e = new Item();
    e.id = faker.random.number();
    e.index = idx;
    e.name = faker.company.bsNoun();
    e.text = faker.company.bsNoun();
    e.maxScore = faker.random.number();

    _.forEach( Comment.valences, function ( valence ) {
        let c = Comment.factory({ valence: valence, text: faker.company.bs()});
        e.addComment( valence, c );
    } );

    return e;
};

export const itemScoreFactory = ( exam, item, student, score ) => {
    let e = new ItemScore();
    e.itemId = _.isUndefined( item ) ? faker.random.number() : item.id;
    e.examId = _.isUndefined( exam ) ? faker.random.number() : item.id;
    e.studentId = _.isUndefined( student ) ? faker.random.number() : student.id;
    e.score = _.isUndefined( score ) ? faker.random.number() : score;
    e.text = faker.company.bs();
    return e;
};

export const noteFactory = () => {
    return Note.factory( {
        name: faker.company.bsNoun(),
        text: faker.company.bsNoun(),
        priority: '',
        props: {},
        createdAt: '',
        associatedItemSerialNumber: faker.random.number()
    } )
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

export const studentFactory = ( index ) => {
    let s = new Student( faker.random.number() );
    s.email = faker.internet.email();
    s.studentIndex = index ? index : faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    s.studentIdentifier = faker.random.number();
    s.lastName = faker.name.lastName();
    s.firstName = faker.name.firstName();
    return s;
};

export const tagFactory = ( id, text, name ) => {
    let tag = new Tag();
    tag.id = _.isUndefined( id ) ? faker.random.number() : id;
    tag.text = _.isUndefined( text ) ? faker.hacker.phrase() : text;
    tag.props = {};
    tag.name = _.isUndefined( name ) ? faker.hacker.phrase() : name;
    return tag;
};


/* ------------ Other --------------------------- */
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

// /