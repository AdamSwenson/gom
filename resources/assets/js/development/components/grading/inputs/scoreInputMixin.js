/**
 * These are common computed properties
 * and methods shared by anything which
 * can alter the score for an item
 */

// import gTypes from '../../../../store/getter-types';
import * as nggTypes from '../../../../store/new-grading-getter-types';
import * as ngmTypes from '../../../../store/new-grading-mutation-types';
import * as ngaTypes from '../../../../store/new-grading-action-types';


module.exports = {

    computed: {
        /**
         * The float score value for the
         * student defined as this.student and
         * item defined as this.item
         */
        score: {
            get: function () {
                let me = this;

                if ( !this.isReady() ) return '';
                // let qs = this.$store.getters.getItemScoreObject( this.item.id, this.student.id );

                let qs = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                    item: me.item,
                    student: me.student
                } );

                if ( !_.isUndefined( qs ) && !_.isNull( qs ) ) {
                    return qs.score;
                }

                let p = this.$store.dispatch( 'initializeItemScore',
                    { exam: this.exam, item: this.item, student: this.student } );

                return p.then( function () {
                    qs = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                        item: me.item,
                        student: me.student
                    } );
                    return qs.score;
                } );

            },
            /**
             * Update the score in the shared data object and send
             * a request for someone else to record it to the server.
             *
             * Note that we use the 'lazy' parameter in the template so that
             * this only syncs once the change event has fired. That prevents
             * us from sending two different requests for a two digit score.
             *
             * @param score
             */
            set: function ( score ) {
                let pl = {
                    exam: this.exam,
                    item: this.item,
                    student: this.student,
                    score: score
                };
                this.$store.dispatch( ngaTypes.recordItemScore, pl );
            }


    },

        exam: function () {
            let e = this.$store.getters[ nggTypes.getActiveExam ];
            return !_.isUndefined( e ) ? e : '';
        },


        /**
         * The maximum possible score for the question
         * @returns {*}
         */
        maxScore: function () {
            if ( _.isUndefined( this.item ) || _.isNull( this.item ) ) return null;

            return Number( this.item.maxScore );
        },

    },

    methods: {
        isReady: function () {
            if ( _.isUndefined( this.item ) || _.isNull( this.item ) ) return false;
            if ( _.isUndefined( this.student ) || _.isNull( this.student ) ) return false;
            return true;
        },
    }
};