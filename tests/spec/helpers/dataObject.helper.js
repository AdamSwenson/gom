/**
 * Created by adam on 8/17/16.
 */
import Student from '../../../resources/assets/js/data/Student';
import Question from '../../../resources/assets/js/data/Question';


var Faker = require('faker');

module.exports = {

    /**
     * Makes a dummy student object
     * with keys studentIndex, //this is here so can use with component
     'studentId'
     'studentIdentifier'
     'firstName'
     'lastName'
     * @param id
     */
    makeStudent(id){
        id = id ? id : Faker.random.number();
        let student = new Student(id);
        student.studentIndex = Faker.random.number();
        student.studentIdentifier = Faker.random.number();
        student.firstName = Faker.name.firstName();
        student.lastName = Faker.name.lastName();
        return student;
    },

    defaultElementComments(){
        return {
            0: {
                0: '',
                1: '',
                2: ''
            },
            1: {
                0: '',
                1: '',
                2: ''
            }
        }
    },

    defaultElementScores(){
        return {
            0: {
                0: null,
                1: null
            },

            1: {
                0: null,
                1: null,
                2: null,
            }
        }
    },
    defaultExamGradingTimes(){
        return {
            0: 0,
            1: 0
        };
    },
    defaultExamGrades(){
        return {
            0: 'Letter grade',
            1: 'Letter grade'
        };
    },
    defaultGrades(){
        return {
            0: {displayValue: 'A+', calcValue: 98},
            1: {displayValue: 'A', calcValue: 95},
            2: {displayValue: 'A-', calcValue: 92},
            3: {displayValue: 'B+', calcValue: 88},
            4: {displayValue: 'B', calcValue: 85},
            5: {displayValue: 'B-', calcValue: 82},
            6: {displayValue: 'C+', calcValue: 78},
            7: {displayValue: 'C', calcValue: 75},
            8: {displayValue: 'C-', calcValue: 72},
            9: {displayValue: 'D+', calcValue: 68},
            10: {displayValue: 'D', calcValue: 65},
            11: {displayValue: 'D-', calcValue: 62},
            12: {displayValue: 'F', calcValue: 55}
        };
    },
    defaultQuestionScores(){
        return {
            0: {
                0: null,
                1: null
            },
            1: {
                0: null,
                1: null
            }
        };
    },

    defaultStockComments(){
        return {
            0: {
                0: 'e0 missing',
                1: 'e0 poor',
                2: 'e0 fair',
                3: 'e0 excellent'
            },
            1: {

                0: 'e1 missing',
                1: 'e1 poor',
                2: 'e1 fair',
                3: 'e1 excellent'
            }
        }
    },

    makeQuestion(index){
        index = index ? index : Faker.random.number();
        let question = new Question(index);
        question.questionIndex = index;
        question.questionName = Faker.lorem.words();
        question.questionNumber = Faker.random.number();
        question.questionAssignmentId = Faker.random.number();
        question.maxScore = Faker.random.number();
    }
}