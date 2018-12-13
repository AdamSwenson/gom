<template>
    <div class="exam-release-control">

        <exam-release-button :exam="exam"></exam-release-button>

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
                modalTitle: "Give students access to their feedback and grade?",
                modalText: "Are you sure? Clicking this will immediately create access keys for students to view their comments and grades. "
            }
        },

        methods: {

            /**
             * Once the modal has been confirmed,
             * this actually sends the request for releasing
             * the exam
             */
            confirmRelease: function () {
                let pl = Payload.factory({obj: this.exam});
                window.console.log( 'exam-release-control', 'confirmRelease', 39, pl);
                if(this.exam.released) {
                    //the request is to remove access
                    this.$store.dispatch(aTypes.revokeExamAccess, pl);
                }else{
                    //the request is to create access
                    this.$store.dispatch(aTypes.releaseExam, pl);
                }

            }
        }
    }
</script>

<style scoped>
    .exam-release-control {
    }

</style>