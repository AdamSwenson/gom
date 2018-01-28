<template>
    <a class="panel-block student-row"
       v-on:toggle-checkbox-delete="handleToggleCheckboxDelete"
       v-show="showRow"
    >
        <span class="panel-icon"><i class="fa fa-user"></i></span>

        <div class="field is-horizontal">
            <div class="field-body">

                <!--<span class="student-properties">-->

                <div class="field">

                    <input type="text"
                           class="input"
                           placeholder="First name"
                           v-model="firstName"
                           v-bind:id="getInputId('firstName')"
                    />
                </div>

                <div class="field">
                    <input type="text"
                           class="input"
                           placeholder="Last name"
                           v-model="lastName"
                           v-bind:id="getInputId('lastName')"
                    />
                </div>
                <div class="field">
                    <input type="text"
                           class="input"
                           placeholder="Student id"
                           v-model="identifier"
                           v-bind:id="getInputId('identifier')"
                    />
                </div>
                <div class="field">
                    <input type="text"
                           class="input"
                           placeholder="Email address"
                           v-model="email"
                           v-bind:id="getInputId('email')"
                    />
                </div>
            </div>
        </div>
        <!--</span>-->


        <!--<student-op-area></student-op-area>-->
        <div class="field is-horizontal">
            <div class="field-body">

                <div class="control delete-operation-area"
                     v-show="showDeleteOperationArea">
                    <label class="checkbox">
                        <input class="checkbox student-operation-checkbox"
                               type="checkbox"
                               v-bind:id="checkboxId"
                               v-model="isSelected">Delete</label>
                </div>

                <div class="control remove-operation-area"
                     v-show="showRemoveOperationArea">
                    <label class="checkbox">
                        <input class="checkbox student-operation-checkbox"
                               type="checkbox"
                               v-bind:id="checkboxId"
                               v-model="isSelected"
                        />Remove</label>
                </div>

                <div class="control move-operation-area"
                     v-show="showMoveOperationArea"
                >
                    <label class="checkbox student-operation-checkbox">
                        <input type="checkbox"
                               class="checkbox"
                               v-bind:id="checkboxId"
                               v-model="isSelected"
                        >Add</label>
                </div>

            </div>
        </div>


        <div class="field is-horizontal"
             v-show="showGradeInfo"
        >
            <div class="field-body">
                <div class="control">
                    <input type="text"
                           class="input"
                           v-model="score"
                           v-bind:id="getInputId('score')">
                </div>
                <div class="control">
                    <input type="text"
                           class="input"
                           v-model="grade"
                           v-bind:id="getInputId('grade')">
                </div>
            </div>
        </div>

    </a>

</template>

<style lang="scss">
    .student-row {
        input {
            border: none;
        }
    }
</style>

<script>
    import Payload from '../../../models/Payload';
    import Student from '../../../models/Student';
    import Kumi from '../../../models/Kumi';
    import * as mTypes from '../../../store/mutation-types';
    import * as aTypes from '../../../store/action-types';
    import * as gTypes from '../../../store/getter-types';

//    import studentOpArea from './student-row-ops-area.vue'

    export default {

        props: [ 'serialNumber' ],

        components: {
//            'student-op-area': studentOpArea
        },

        data: function () {
            return {

                /**
                 * Whether to display the checkbox by which
                 * the student is selected for being moved,
                 * removed, or deleted
                 */
//                showOperationCheckbox: false,

                /**
                 * Gets the label to display with the checkbox
                 * i.e., Delete, Move, Remove
                 */
                operationCheckboxLabel: 'Delete | Move | Remove',


                defaults: {
                    firstName: '-',
                    lastName: '-',
                    email: '-',
                    identifier: '-'
                }
            }
        },

        computed: {
//        asyncComputed: {
            student: function () {
                return this.$store.getters.getStudentFromRosterBySerialNumber( this.serialNumber );
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

            lastName: {
                get: function () {
                    //todo capitalize?
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

            isStudentInSelectedKumi: function () {
                return this.$store.getters.isStudentInSelectedKumis( this.student );
            },

            /**
             * Whether this row is selected
             */
            isSelected: {
                get: function () {
                    return this.$parent.selectedStudents.indexOf( this.student ) > -1;
                },
                set: function ( v ) {
                    let idx = this.$parent.selectedStudents.indexOf( this.student );
                    if ( idx > -1 ) {
                        //already selected, so remove
                        return this.$parent.selectedStudents.splice( idx, 1 );
                    }
                    this.$parent.selectedStudents.push( this.student );
                }
            },
            /**
             * Whether to display score and other
             * info about how the student has done.
             * (Note 'done on what?' is resolved by context
             * since we want to be able to call this menu
             * up in many contexts ---maybe on item score, exam score
             */
            showGradeInfo: function () {
                return false;
            },

//these need to be here for the op area to read
            /**
             * Whether to display the checkbox by which
             * the student is selected for being moved,
             * removed, or deleted
             */
            showOperationCheckbox: function () {
                return this.$parent.showDeleteOperationArea;
            },

            /**
             * Gets the label to display with the checkbox
             * i.e., Delete, Move, Remove
             */
//            operationCheckboxLabel: 'Delete | Move | Remove',


            /**
             * Whether to display the checkbox by which
             * the student is selected for being moved,
             * removed, or deleted
             */
            showDeleteOperationArea: function () {
                return this.$parent.showDeleteOperationArea;
            },

            /**
             * Whether to display the checkbox by which
             * the student is selected for being moved,
             * removed, or deleted
             */
            showMoveOperationArea: function () {
                return this.$parent.showMoveOperationArea;
            },

            /**
             * Whether to display the checkbox by which
             * the student is selected for being moved,
             * removed, or deleted
             */
            showRemoveOperationArea: function () {
                return this.$parent.showRemoveOperationArea;
            },

            //            /**
            //             * Gets the label to display with the checkbox
            //             * i.e., Delete, Move, Remove
            //             */
            //            operationCheckboxLabel: function () {
            //                return 'Delete | Move | Remove';
            //            },

            /**
             * Whether the row is visible
             */
            showRow: function () {
                if ( this.$parent.showKumi === -1 ) return true;

                let kumi = this.$store.getters.getKumiBySerialNumber( this.$parent.showKumi );

                return this.student.associatedKumis.indexOf( kumi ) > -1;
            },

            /**
             * Getter for the students grade, if displayed
             */
            grade: function () {
            },

            /**
             * Getter for the student's score, if displayed
             */
            score: function () {
            },

            checkboxId: function () {
                return 'student-operation-checkbox-' + this.serialNumber;
            }
        }
        ,

        methods: {
            getInputId: function ( name ) {
                return _.kebabCase( name ) + '-' + this.serialNumber;
            }
            ,

            getCheckboxValue: function () {
                return this.student.serialNumber;
            },

            handleToggleCheckboxDelete: function ( evt ) {
                window.console.log( 'student-row', 'toggle-checkbox-delete', 203, 'caught', evt );
                this.operationCheckboxLabel = 'Delete';
                this.showOperationCheckbox = !this.showOperationCheckbox;
            }
            ,
//
//            handleRowSelection: function () {
//                let idx = this.$parent.selectedStudents.indexOf( this.student );
//                if ( idx > -1 ) {
//                    //already selected, so remove
//                    return this.$parent.selectedStudents.splice( idx, 1 );
//                }
//                this.$parent.selectedStudents.push( this.student );

//            }

        },

        events: {
//            'toggle-checkbox-delete': function (evt) {
//
////                'toggle-checkbox-delete': function (evt) {
//                window.console.log( 'student-row', 'toggle-checkbox-delete', 203, 'caught' , evt);
//                this.operationCheckboxLabel = 'Delete';
//                this.showOperationCheckbox = !this.showOperationCheckbox;
//            },

            'toggle-checkbox-move': function () {
                window.console.log( 'student-row', 'toggle-checkbox-move', 207, 'caught' );
                this.operationCheckboxLabel = 'Move';
                this.showOperationCheckbox = !this.showOperationCheckbox;
            }

            ,

            'toggle-checkbox-remove': function () {
                window.console.log( 'student-row', 'toggle-checkbox-remove', 211, 'caught' );
                this.operationCheckboxLabel = 'Remove';
                this.showOperationCheckbox = !this.showOperationCheckbox;
            }
        }
    }
    ;
</script>