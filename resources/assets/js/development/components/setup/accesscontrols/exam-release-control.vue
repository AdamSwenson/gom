<template>
    <div class="exam-release-control">
        <div class="field">
            <!--<label class="label">{{options.label}}</label>-->
            <div class="control">
                <exam-release-button :exam="exam"></exam-release-button>
            </div>
            <p class="help">{{displayText}}</p>
        </div>

        <confirmation-modal
                v-on:confirm-selected="confirmRelease"
        >
            <span slot="modalTitle">{{modalTitle}}</span>
            <span slot="modalBody">{{modalText}}</span>

        </confirmation-modal>
    </div>
</template>

<script>
    import ExamReleaseButton from "./exam-release-button";
    import ConfirmationModal from "../../modals/confirmation-modal";
    import Payload from '../../../../models/Payload';
    import * as aTypes from '../../../../store/action-types'

    export default {
        name: "exam-release-control",
        components: { ConfirmationModal, ExamReleaseButton },

        props: [ 'exam' ],

        data: function () {
            return {
                isModalVisible: false,
                options: {
                    displayText: {
                        grant: "Students presently do not have access to their feedback and grade",
                        remove: "Students have access to their feedback and grade"
                    },
                    label: 'Control student access',
                    modalTitle: {
                        grant: "Give students access to their feedback and grade?",
                        remove: "Remove access to students' feedback and grade?"
                    },

                    modalText: {
                        grant: "Are you sure? \n Clicking this will immediately create access keys for students to view their comments and grades. ",
                        remove: "Are you sure? \nClicking this will immediately remove all students' ability to view their comments and grades. "
                    }
                }
            }
        },
        computed: {
            displayText: function () {
                if ( this.isReleased ) {
                    return this.options.displayText.remove;
                }
                return this.options.displayText.grant;
            },

            isReleased: function () {
                if ( !_.isUndefined( this.exam ) ) {
                    return this.exam.released;
                }
                return false;
            },

            modalText: function () {
                if ( this.isReleased ) {
                    return this.options.modalText.remove;
                }
                return this.options.modalText.grant;
            },

            modalTitle: function () {
                if ( this.isReleased ) {
                    return this.options.modalTitle.remove;
                }
                return this.options.modalTitle.grant;
            }

        },

        methods: {

            /**
             * Once the modal has been confirmed,
             * this actually sends the request for releasing
             * the exam
             */
            confirmRelease: function () {
                let pl = Payload.factory( { obj: this.exam } );
                window.console.log( 'exam-release-control', 'confirmRelease', 39, pl );
                if ( this.isReleased ) {
                    //the request is to remove access
                    this.$store.dispatch( aTypes.revokeExamAccess, pl );
                } else {
                    //the request is to create access
                    this.$store.dispatch( aTypes.grantExamAccess, pl );
                }
            },

        }
    }
</script>

<style scoped>
    .exam-release-control {
    }

</style>