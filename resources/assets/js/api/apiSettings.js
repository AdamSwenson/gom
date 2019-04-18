/**
 * Created by adam on 7/6/17.
 */

//Not exported!
const KUMI_BASE_ROUTE = 'dev/kumis';
const GRADING_BASE_ROUTE = 'dev/grading';
const NOTES_BASE_ROUTE = 'dev/notes';
const ROSTER_BASE_ROUTE = 'dev/roster';
const SCORE_BASE_ROUTE = 'dev/scores';
const STUDENT_BASE_ROUTE = 'dev/students';
const TAGS_BASE_ROUTE = 'dev/tags';


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
    setupExam: ( exam ) => {
        return 'dev/setup/' + exam.id;
    },
    newExam: () => {
        return 'dev/setup/';
    },
    updateExam: ( exam ) => {
        //should be used with put
        return 'dev/exam/' + exam.id;
    },
    getExam: ( examId ) => {
        return 'dev/exam/' + examId;
    },
    gradeExam: ( examId ) => {
        return GRADING_BASE_ROUTE + '/' + examId;
    },

    // ------------------ Student access to feedback
    studentAccess: ( exam ) => {
        return 'dev/studentaccess/' + exam.id;
    },

// ------------------------- Kumi
    associateKumi: ( kumi, exam ) => {
        return KUMI_BASE_ROUTE + '/' + kumi.id + 'exam/' + exam.id + '/new';
    },
    disassociateKumi: ( kumi, exam ) => {
        return KUMI_BASE_ROUTE + '/' + kumi.id + '/exam/' + exam.id;
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

    // ------------------------- Info


    // ------------------------- Items
    createItem: () => {
        return 'items'
    },
    loadAllItems: () => {
        return 'items';
    },
    loadAllItemsForExam: ( examId ) => {
        return 'items/exam/' + examId;
    },
    updateItem: ( item ) => {
        return 'items/' + item.id;
    },
    updateItemsOrder: ( exam ) => {
        return 'dev/setup/' + exam.id + '/order';
    },

    // ------------------------- History
    getItemHistory: ( item ) => {
        return 'dev/history/item/' + item.id;
    },
    getStudentHistory: ( student ) => {

    },

    // ------------------------- Notes
    createItemNote: ( item ) => {
        return NOTES_BASE_ROUTE + '/item/' + item.id
    },
    createExamNote: ( exam ) => {
        return NOTES_BASE_ROUTE + '/exam/' + exam.id
    },
    updateNote: ( note ) => {
        return NOTES_BASE_ROUTE + '/' + note.id
    },
    destroyNote: ( note ) => {
        return NOTES_BASE_ROUTE + '/' + note.id
    },
    getNotesForItem: ( item ) => {
        return NOTES_BASE_ROUTE + '/item/' + item.id
    },
    getNotesForExam: ( exam ) => {
        return NOTES_BASE_ROUTE + '/exam/' + exam.id
    },


    // ------------------------- Scores
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

    // ------------------------- Students
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
    loadStudentsForExam: ( exam ) => {
        return ROSTER_BASE_ROUTE + '/exam/' + exam.id;
    },
    updateStudent: ( student ) => {
        return STUDENT_BASE_ROUTE + '/' + student.id
    },


    //Stats (no identifying student data)
    // getExamSummaryStats:

    //Tags
    createTag: () => {
        return TAGS_BASE_ROUTE
    },
    updateTag: ( tag ) => {
        return TAGS_BASE_ROUTE + '/' + tag.id
    },
    destroyTag: ( tag ) => {
        return TAGS_BASE_ROUTE + '/' + tag.id
    },
    getAllUserTags: () => {
        return TAGS_BASE_ROUTE
    },
    getTagsForItem: ( item ) => {
        return TAGS_BASE_ROUTE + '/item/' + item.id
    },
    getTagsForExam: ( exam ) => {
        return TAGS_BASE_ROUTE + '/exam/' + exam.id
    },
    getTagsForStudent: ( student ) => {
        return TAGS_BASE_ROUTE + '/student/' + exam.id
    },
    //associate and disassociate
    //depending on whether send post or delete
    tagExam: ( exam, tag ) => {
        return TAGS_BASE_ROUTE + '/exam/' + exam.id + '/tag/' + tag.id
    },
    tagItem: ( item, tag ) => {
        return TAGS_BASE_ROUTE + '/item/' + item.id + '/tag/' + tag.id
    },
    tagStudent: ( student, tag ) => {
        return TAGS_BASE_ROUTE + '/student/' + student.id + '/tag/' + tag.id
    },

};

let makeRoute = ( link ) => {
    return window.routeRoot + '/' + link;
}
/**
 * Returns a list of objects defining the links for
 * the various information and help pages
 *
 * @constructor
 */
export const InformationLinks =
    [
        { text: 'Help', link: makeRoute( 'help' ) },
        { text: 'FAQ', link: makeRoute( 'info/faq' ) },
        { text: 'Instructions', link: makeRoute( 'info/instructions' ) },
        { text: 'Video tutorials', link: makeRoute( 'info/tutorials' ) },

    ];

export const BusinessLinks = [
    { text: 'Contact', link: makeRoute( 'contact' ) },
    { text: 'About', link: makeRoute( 'about' ) },
];

export const SettingsLinks = [
    { text: 'Grading page settings', type: 'grade', route: '/preferences/grade' },
    { text: 'Setup page settings', type: 'setup', route: '/preferences/setup' },
    { text: 'User settings', type: 'user', route: '/preferences/user' },
];

// `transformRequest` allows changes to the request data before it is sent to the server
// This is only applicable for request methods 'PUT', 'POST', and 'PATCH'
// The last function in the array must return a string, an ArrayBuffer, FormData, or a Stream
// window.axios.defaults.transformRequest = function ( data ) {
//     // Do whatever you want to transform the data
//     window.console.log( 'axiosConfig', 'transformRequest', 56 );
//     return data;
// };
//
// // `transformResponse` allows changes to the response data to be made before
// // it is passed to then/catch
// window.axios.defaults.transformResponse = function ( data ) {
//     // Do whatever you want to transform the data
//     window.console.log( 'axiosConfig', 'transformResponse', 26 );
//     return data;
// };

// window.axios.defaults.onUploadProgress = function ( progressEvent ) {
//     // Do whatever you want with the native progress event
//     window.console.log( 'axiosConfig', 'onUploadProgress', 90, );
// };
//
// // `onDownloadProgress` allows handling of progress events for downloads
// window.axios.defaults.onDownloadProgress = function ( progressEvent ) {
//     // Do whatever you want with the native progress event
//     window.console.log( 'axiosConfig', 'onDownloadProgress', 95, );
// };
//

