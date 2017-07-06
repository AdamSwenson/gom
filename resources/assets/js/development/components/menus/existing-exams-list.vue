<!--This can be used in a modal or other menu to select a different exam to do stuff to-->
<template>
    <div class="exams-panel panel">
        <p class="panel-heading">
            Exams
        </p>

        <div class="panel-block">
            <p class="control has-icons-left">
                <input class="input is-small" type="text" placeholder="Search">
                <span class="icon is-small is-left">
                        <i class="fa fa-search"></i>
                    </span>
            </p>
        </div>

        <p class="panel-tabs">
            <a class="is-active">All</a>
            <a>Ungraded</a>
            <a>Graded</a>
            <a>Tags</a>
        </p>

        <a v-for="exam in exams"
           v-on:click="handleRowClick(exam.id)"
           :key="exam.id"
           class="panel-block ">
                <span class="panel-icon">
                    <i class="fa fa-book"></i>
                </span>
            {{exam.name}}
        </a>


        <div class="panel-block">
            <button class="button is-primary is-outlined is-fullwidth"
                    v-on:click="handleNew">
                {{ newButtonLabel }}
            </button>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>

    import Item from '../../../models/Item'
    import Exam from '../../../models/Exam'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    import api from '../../../api/requests/examRequests'

    export default{

        props: [],

        components: {},

        data: function () {
            return {
                newButtonLabel: "New Exam",

                defaults: {}
            }
        },

        computed: {
            currentExam: function () {
                return this.$store.getters.currentExam;
            }
        },

        asyncComputed: {
            exams: function () {
                let e = this.$store.getters.getAllExams;
                if ( e.length > 0 ) return e;

                return window.axios
                    .get( 'dev/exams' )
                    .then( ( response ) => {
                        window.console.log( 'examRequests', '', 28, response );
                        let out = [];
                        _.forEach( response.data, function ( r ) {
                            let exam = Exam.factory( { r } );
                            exam.id = r.id;
                            exam.name = r.name;
                            exam.term = r.term;
                            out.push( exam );
                        } );
                        return out;
                    } );
            }
        },

        watch: {
            //Once the api has given us the exams, we add them to store
            //so that others can use them
            exams: function ( newVal, oldVal ) {
                _.forEach( newVal, ( exam ) => {
                    let payload = Payload.factory( { obj: exam, mutateSilently: true } );
                    this.$store.commit( mTypes.addExam, payload );
                } );
            }
        },

        methods: {
            handleRowClick: function ( v ) {
                window.console.log( 'existing-exams-list', 'handleClick', 110, v );
            },

            handleNew: function () {
                window.console.log( 'existing-exams-list', 'handleNew', 114, this );
            },

            addExam: function () {

            },
            showExam: function ( v ) {
                window.console.log( 'existing-exams-list', 'showExam', 75, v );

            },

            getExams: function () {
                return this.$store.getters.getAllExams;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>