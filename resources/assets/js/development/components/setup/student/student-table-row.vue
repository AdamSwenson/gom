<template>

    <tr class="student-row"
        v-bind:class="rowStyling"
        v-show="isRowVisible"
    >

        <td v-on:click="handleRowSelection">
            <div class="field">
                <span class="icon">
                    <i class="fa" v-bind:class="icon"></i>
                </span>
            </div>
        </td>

        <td>
            <div class="field">

                <input type="text"
                       class="input"
                       placeholder="First name"
                       v-model="firstName"
                       aria-label="First name"
                       v-bind:id="getInputId('firstName')"
                />
            </div>
        </td>

        <td>
            <div class="field">
                <input type="text"
                       class="input"
                       placeholder="Last name"
                       aria-label="Last name"
                       v-model="lastName"
                       v-bind:id="getInputId('lastName')"
                />
            </div>
        </td>

        <td>
            <div class="field">
                <input type="text"
                       class="input"
                       placeholder="Student id"
                       aria-label="Student id"
                       v-model="identifier"
                       v-bind:id="getInputId('identifier')"
                />
            </div>
        </td>

        <td>
            <div class="field">
                <input type="text"
                       class="input"
                       placeholder="Email address"
                       aria-label="Email address"
                       v-model="email"
                       v-bind:id="getInputId('email')"
                />
            </div>
        </td>

        <td v-if="isGradeInfoVisible"
        >
            <div class="field is-horizontal grade-area">
                <div class="field-body">
                    <div class="control">
                        <input type="text"
                               class="input"
                               v-model="score"
                               aria-label="Score"
                               v-bind:id="getInputId('score')">
                    </div>
                    <div class="control">
                        <input type="text"
                               class="input"
                               v-model="grade"
                               aria-label="Grade"
                               v-bind:id="getInputId('grade')">
                    </div>
                </div>
            </div>
        </td>

    </tr>
</template>

<style lang="scss">
    .student-row {
        input {
            border: none;
        }
    }
</style>

<script>
    import Payload from '../../../../models/Payload';
    import Student from '../../../../models/Student';
    import Kumi from '../../../../models/Kumi';
    import * as mTypes from '../../../../store/mutation-types';
    import * as aTypes from '../../../../store/action-types';
    import * as gTypes from '../../../../store/getter-types';

    //    import studentOpArea from './student-row-ops-area.vue'

    export default {

        props: [ 'student' ],

        components: {
//            'student-op-area': studentOpArea
        },

        data: function () {
            return {
                defaults: {
                    firstName: '-',
                    lastName: '-',
                    email: '-',
                    identifier: '-'
                }
            }
        },


        computed: {
            displayedKumis : function (  ) {
                return this.$store.getters.getDisplayedKumis;
            },

            icon: function () {
                return this.isSelected ? 'fa-check-circle-o' : 'fa-circle-thin';
            },

            email: {
                get: function () {
                    return this.student.email;
                },
                set: function ( v ) {
                    this.$store.commit( 'updateStudentInRoster', Payload.factory( {
                        obj: this.student,
                        updateProp: 'email',
                        updateVal: v
                    } ) );
                }
            },

            firstName: {
                get: function () {
                    return this.student.firstName;
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.student,
                        updateProp: 'firstName',
                        updateVal: _.capitalize( v )
                    } );
                    this.$store.commit( 'updateStudentInRoster', pl );
                }
            },

            /**
             * Getter for the students grade, if displayed
             */
            grade: function () {
                if ( this.student.grade ) return this.student.grade;
            },

            identifier: {
                get: function () {
                    return this.student.identifier;
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.student,
                        updateProp: 'studentIdentifier',
                        updateVal: v
                    } );
                    this.$store.commit( 'updateStudentInRoster', pl );
                }
            },


            /**
             * Whether to display score and other
             * info about how the student has done.
             * (Note 'done on what?' is resolved by whether
             * the student has a grade or a score set on the object
             */
            isGradeInfoVisible: function () {
                if ( !_.isNull( this.student.grade ) || !_.isNull( this.student.score ) ) return true;
                return false;
            },

            /**
             * Whether the row is visible
             */
            isRowVisible: function () {
                if(this.displayedKumis.length === 0) return true;

                return this.$store.getters.isStudentInDisplayedKumi( this.student );

            },

            selectedStudents : function (  ) {
                return this.$store.getters.getSelectedStudents;
            },

            isSelected: function(){
                if(_.isUndefined(this.selectedStudents)) return false;
                return this.selectedStudents.indexOf(this.student) > -1;
            },



            lastName: {
                /**
                 * todo capitalize? Probably not since there may be particular spellings that this would corrupt
                 */
                get: function () {
                    return this.student.lastName;
                },
                set: function ( v ) {
                    this.$store.commit( 'updateStudentInRoster', Payload.factory( {
                        obj: this.student,
                        updateProp: 'lastName',
                        updateVal: _.capitalize( v )
                    } ) );
                }
            },

            /**
             * The class of the row is bound to this
             */
            rowStyling: function () {
                if ( this.isSelected ) return 'is-selected';
            },

            /**
             * Getter for the student's score, if displayed
             */
            score: function () {
                if ( this.student.score ) return this.student.score;
            },

        },

        directives: {
            /**
             * Triggers the row selection event handler
             */
            selectsRows: function ( evt ) {
                window.console.log( 'student-table-row', 'selectsRows', 241, evt );
            }
        },

        methods: {
            getInputId: function ( name ) {
                return _.kebabCase( name ) + '-' + this.serialNumber;
            },

            /**
             * Handles each click on the row
             *
             * NB, we don't want data input events bubbling up
             * and calling this
             */
            handleRowSelection: function ( evt ) {
                window.console.log( 'student-table-row', 'handleRowSelection', 247, this.student, evt );
                //toggle the selected state
                this.$store.commit('toggleStudent', Payload.factory({
                    obj: this.student,
                    mutateSilently: true
                }));

                //let any interested parent know
                this.$emit( 'row-selection-event', {
                    obj: this.student,
                    isSelected: this.isSelected
                } );
            }

        },

    };
</script>