
const faker = require('faker');
import GradeAssignment from "../../../resources/assets/js/models/GradeAssignment";


// Factories

export const makeGradeFrequencyObject = (  ) => {
    let testFreqs = {};
    _.forEach(GradeAssignment.defaults, function(ga){
        testFreqs[ga.displayValue] = faker.random.number();
    });
    return testFreqs;
};



export const makeScoreListServerResponse = (  ) => {
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