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

    ElementScoreRequest: function(studentIndex, elementId){
        this.studentIndex = studentIndex;
        this.elementId = elementId;
    },

    StudentSelectEvent: function(studentName, studentIdentifier){
        this.studentName = studentName;
        this.studentIdentifier = studentIdentifier;
    }
};