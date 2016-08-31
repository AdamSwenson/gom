/**
 * Created by adam on 7/26/16.
 */


/**
 * These create uniformity in what is expected to be included along with
 * events
 */
module.exports = {

    /**
     * Object transmitted with requests about questionScores
     * @param studentIndex
     * @param questionIndex
     * @param questionAssignmentId
     */
    QuestionScoreRequest: function(studentIndex, questionIndex, questionAssignmentId){
        this.studentIndex = studentIndex;
        this.questionIndex = questionIndex;
        this.questionAssignmentId = questionAssignmentId;
    },


    CommentRequest: function(studentIndex, elementIndex, elementId){
        this.elementId = elementId;
        this.elementIndex = elementIndex;
        this.studentIndex = studentIndex;
    },

    ElementScoreRequest: function(studentIndex, elementIndex, score, elementId){
        this.studentIndex = studentIndex;
        this.elementIndex= elementIndex;
        this.score = score;
        this.elementId = elementId;
    },

    StudentSelectEvent: function(studentName, studentIdentifier){
        this.studentName = studentName;
        this.studentIdentifier = studentIdentifier;
    }
};