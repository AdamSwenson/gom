/**
 * Created by adam on 7/11/16.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/student-list-item.template.html' ),

    props: [
        'studentIndex',
        'firstName',
        'lastName',
        'studentIdentifier',
        'studentId',
        'examGrade'
        
    ],

    data: function () {
        return {
            examGradePlaceholder: '--',
            studentIdentifierPlaceholder: '--'
        };
    },

    computed: {
        examGrade: function(){
            if((this.examGrade != 'undefined') && (this.examGrade != '')) {
                return this.examGrade;
            }
            else {
                return this.examGradePlaceholder;
            }
        }, 
        
        studentIdentifierDisplay : function(){
            if((this.studentIdentifier != 'undefined') && (this.studentIdentifier != '')) {
                return this.studentIdentifier;
            }
            else {
                return this.studentIdentifierPlaceholder;
            }
        },
        
        studentName : function(){
            return this.lastName + ", " + this.firstName;
        }
    },

    methods: {},

    directives: {}
};