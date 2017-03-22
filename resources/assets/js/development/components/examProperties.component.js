/**
 * This allows for editing the properties of the exam
 * Created by adam on 2/15/17.
 */

module.exports = {

    template: require( '../templates/exam-properties.template.html' ),

    props: ['exam-id'],

    data: function () {
        return {
            isHidden: true
        };
    },

    computed: {
        /**
         * Name which will be visible to students when they see the exam.
         * Otherwise it will just be referred to as 'Your exam' or
         * 'Your assignment'
         */
        publicName: {
            get: function () {
            }, set: function () {
            }
        },
        terms: {
            get: function () {
            }, set: function () {
            }
        },
        term: {
            get: function () {
            }, set: function () {
            }
        },
        year: {
            get: function () {
            }, set: function () {
            }
        },
        years: {
            get: function () {
            }, set: function () {
            }
        },
    },

    methods: {
        openPropsArea: function () {
            //make visible
            this.isHidden = false;
        },

        closePropsArea: function () {
            //hide
            this.isHidden = true;
        },


        togglePropsArea: function () {
            //hide
            this.isHidden = !this.isHidden;
        }
    },

    directives: {},

    events: {
        /**
         * If properties are showing, hide them; or vice-versa
         */
        'toggle-exam-properties': function () {
            this.togglePropsArea();
        },
        /**
         * Display exam properties area
         */
        'open-exam-properties': function () {
            this.openPropsArea();
        },
        /**
         * Close exam properties area
         */
        'close-exam-properties': function () {
            this.closePropsArea();
        },
    },

    ready: function () {
        //check if exam id was provided,
        // if not, create a new exam object and set it
        // as active.
        if(typeof this.examId == 'undefined'){

        }
        //Also get ready to request an exam id from the server
        //as soon as the user does something which alters the store
        console.log( 'exam-properties ready' );
    },
};