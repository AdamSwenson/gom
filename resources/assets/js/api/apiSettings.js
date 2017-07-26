/**
 * Created by adam on 7/6/17.
 */

//Not exported!
    const KUMI_BASE_ROUTE = 'dev/kumis/';
const ROSTER_BASE_ROUTE = 'dev/roster';
const SCORE_BASE_ROUTE = 'dev/scores';
const STUDENT_BASE_ROUTE = 'dev/students';


export const REQUEST_VERSION = 1;
export const ID_WAIT_TIMEOUT = 5000;
export const POLL_TIMEOUT = 100;

//Single location for routes to make
//editing easier
export const Routes = {
    commonBaseRoute: 'dev/setup',

    // ------------------------- Comments
    updateComment: ( item ) => {
        return 'comments/' + item.id;
    },

    // ------------------------- Exams
    loadAllExams: () => {
        return 'dev/exams/';
    },

    updateExam: ( exam ) => {
        return 'editexam/' + exam.id;
    },

    // ------------------------- Kumi
    associateKumi: ( kumi, exam ) => {
        return KUMI_BASE_ROUTE + '/' + kumi.id + 'exam/' + exam.id + '/new';
    },

    createKumi: () => {
        return KUMI_BASE_ROUTE;
    },

    destroyKumi: ( kumi ) => {
        return KUMI_BASE_ROUTE;
    },

    updateKumi: ( kumi ) => {
        return KUMI_BASE_ROUTE + '/' + kumi.id;
    },

    loadExamKumi: ( exam ) => {
        return KUMI_BASE_ROUTE + '/exam/' + exam.id;
    },

    loadAllKumi: () => {
        return KUMI_BASE_ROUTE;
    },


    // ------------------------- Items
    createItem: () => {
        return 'items'
    },
    loadAllItems: () => {
        return 'items';
    },

    updateItem: ( item ) => {
        return 'items/' + item.id;
    },

    updateItemsOrder: ( exam ) => {
        return 'dev/setup/' + exam.id + '/order';
    },


    //--------------- Scores
    saveScore: ( score ) => {
        return SCORE_BASE_ROUTE;
    },

    getExamScoreRequest: ( exam ) => {
        return SCORE_BASE_ROUTE + '/exam/' + exam.id;
    },

    getStudentScoreRequest: ( student ) => {
        return SCORE_BASE_ROUTE + '/student/' + student.id;
    },

    getItemScoreRequest: ( item ) => {
        return SCORE_BASE_ROUTE + 'item/' + item.id;
    },

    // ---------------- Students
    anonymizeStudents: ( exam ) => {
        return `${ROSTER_BASE_ROUTE}/anon/{exam.id}`;
    },

    associateStudent: ( student, kumi ) => {
        return `${ROSTER_BASE_ROUTE}/${student.id}/assoc/${kumi.id}`;
    },

    createStudent: () => {
        return STUDENT_BASE_ROUTE;
    },

    destroyStudent: ( student ) => {
        return `${STUDENT_BASE_ROUTE}/${student.id}`;
    },

    disassociateStudent: ( student, kumi ) => {
        return `${ROSTER_BASE_ROUTE}/${student.id}/diss/${kumi.id}`;
    },

    loadAllStudents: () => {
        return STUDENT_BASE_ROUTE;
    },

    loadStudent: ( student ) => {
        return STUDENT_BASE_ROUTE + '/' + student.id;
    },

    updateStudent: ( student ) => {
        return STUDENT_BASE_ROUTE + '/' + student.id
    },

};
