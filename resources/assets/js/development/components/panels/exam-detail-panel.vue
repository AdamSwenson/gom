<template>

    <div class="exam-detail-panel  ">
        <div class="box">

            <div class="public-name-input field">
                <label class="label">Public Name</label>
                <p class="control">
                    <input type="text"
                           class="input"
                           id="publicName"
                           name="publicName"
                           v-model="publicName"
                           v-bind:placeholder="placeholders.publicName"
                    >
                </p>
            </div>

            <div id="term-entry"
                 class="field has-addons">

                <label class="label">Term</label>

                <p class="control">
                <span class="select">
                    <select>
                        <option v-for="term in terms" :key="term">{{term}}</option>
                    </select>
                </span>
                </p>

                <p class="control">
                    <input id="term"
                           type="text"
                           class="input" aria-label="term-text"
                           v-model="term">
                </p>
            </div>

            <div id="year-entry"
                 class="field has-addons">
                <label class="label">Year</label>
                <p class="control">
                <span class="select">
                    <select>
                        <option v-for="year in years" :key="year">year</option>
                    </select>
                </span>
                </p>
                <p class="control">
                    <input
                            type="number"
                            class="input" aria-label="year-text"
                            v-model="year">
                </p>
            </div>
        </div>
    </div>

</template>

<style type="scss">
    .exam-detail-panel {
        .public-name-input {
            label {
                text-align: left;
            }
        }
    }

</style>

<script>

    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    import Payload from '../../../models/Payload'


    export default {

        props: [ 'exam-id' ],

        data: function () {
            return {
                serialNumber: _.toInteger( this.$route.params.serialNumber ),
                active: this.serialNumber,

                defaults: {
                    term: 'Term'
                },
                placeholders: {
                    publicName: "If you would like students to see a different name for the exam, enter the name you would like them to see here"
                },

                //0 index always has an exam
                index: 0,

                terms: [ 'fall', 'winter', 'spring', 'summer' ],
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
                    let exam = this.getExam();
                    if ( exam && typeof exam.publicName !== 'undefined' ) {
                        return exam.publicName;
                    }
                },
                set: function ( v ) {
                    this.$store.commit( mTypes.updateItem, Payload.factory( {
                        index: 0,
                        updateProp: 'publicName',
                        updateVal: v
                    } ) );
                }
            },

            term: {
                get: function () {
                    let exam = this.getExam();
                    if ( exam && typeof exam.term !== 'undefined' ) {
                        return exam.term;
                    }

                },
                //Sets the term
                //Note, the input box allows the entered
                //value not to be one of the standard values
                //this is by design.
                //We are not being too prescriptive, remember?
                set: function ( v ) {
                    this.$store.commit( mTypes.updateItem, Payload.factory( {
                        index: 0,
                        updateProp: 'term',
                        updateVal: v
                    } ) );
                }
            },
            year: {
                get: function () {
                    let exam = this.getExam();
                    if ( exam && typeof exam.year !== 'undefined' ) {
                        return exam.year;
                    }
                },
                set: function ( v ) {
                    this.$store.commit( mTypes.updateItem, Payload.factory( {
                        index: 0,
                        updateProp: 'year',
                        updateVal: v
                    } ) );

                }
            },

            years: function () {
                return [ 2017, 2018 ];
            },

        },

        methods: {
            selectTerm: function () {
//                window.console.log('panel.exam-detail.component', 'selectTerm', 167, this);
            },
            getExam: function () {
                return this.$store.getters.getItemByIndex( 0 );
//                return this.$store.getters[ gTypes.getActiveExamObj ];
            },

            updateExam: function () {

            }

        },

        directives: {},

        events: {},

        mounted: function () {
        },
    };
</script>
