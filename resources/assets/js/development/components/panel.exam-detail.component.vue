<template>
    <div class="panel-exam-detail-component  ">

        <div class="field">
            <label class="label">Public Assignment Name</label>
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

        <div class="field">
            <label class="label">Subject</label>
            <p class="control">
                <span class="select">
                    <select>
                        <option v-for="term in terms" :key="term">term</option>
                    </select>
                </span>
            </p>
        </div>

        <div class="field">
            <label class="label">Term</label>
            <input id="term"
                   type="text"
                   class="input" aria-label="term-text"
                   v-model="term">
        </div>

        <div class="field has-addons">
            <label class="label">Year</label>
            <p class="control">
                <button type="button"
                        class="button is-outlined "
                        v-mode="year">
                </button>
            </p>

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
                        class="form-control" aria-label="year-text"
                        v-model="year">
            </p>

        </div><!-- /btn-group -->
    </div><!-- /input-group -->


    <!--<div class="field">-->
    <!--<label class="label">Public Assignment Name</label>-->
    <!--<p class="control">-->
    <!--<button type="button"-->
    <!--class="button "-->
    <!--data-toggle="dropdown"-->
    <!--aria-haspopup="true"-->
    <!--aria-expanded="false">Term <span-->
    <!--class="caret"></span></button>-->
    <!--<ul class="dropdown-menu">-->
    <!--<li v-for="term in terms">-->
    <!--<a href="#">{{term}}</a>-->
    <!--</li>-->
    <!--</ul>-->
    <!--</div>&lt;!&ndash; /btn-group &ndash;&gt;-->
    <!--<input id="term"-->
    <!--type="text"-->
    <!--class="form-control" aria-label="term-text"-->
    <!--v-model="term">-->
    <!--</div>&lt;!&ndash; /input-group &ndash;&gt;-->

    <!--<b-dropdown v-bind:text="term"-->
    <!--variant="primary"-->

    <!--&gt;-->
    <!--<b-dropdown-item href="#">Winter</b-dropdown-item>-->
    <!--<b-dropdown-item href="#">Spring</b-dropdown-item>-->
    <!--<b-dropdown-item href="#">Summer</b-dropdown-item>-->
    <!--<b-dropdown-item href="#">Fall</b-dropdown-item>-->
    <!--</b-dropdown>-->
    <!--</div>-->

    <!--<div class="col-md-1">-->
    <!--<span class="glyphicon glyphicon-question-sign"></span>-->
    <!--</div>-->
    <!--<list-dropdown type="term"></list-dropdown>-->

    </div>
    <div class="row">
        <div class="col-md-3">

            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button"
                            class="btn btn-default dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">Year <span
                            class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li v-for="year in years">
                            <a href="#">{{year}}</a>
                        </li>
                    </ul>
                </div><!-- /btn-group -->
                <input id="year"
                       type="number"
                       class="form-control" aria-label="year-text"
                       v-model="year">
            </div><!-- /input-group -->
        </div>
    </div>
    </div>

</template>

<style>

</style>

<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';
    import * as gTypes from '../../store/getter-types';

    import Payload from '../../models/Payload'


    export default{

        props: [ 'exam-id' ],

        data: function () {
            return {
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
            console.log( 'exam-edit-pane ready' );
        },
    };
</script>
