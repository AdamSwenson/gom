<template>
    <div class="exam-release-control">
        <div class="field">
            <label class="label">{{options.label}}</label>
            <div class="control">
                <send-notification-email-button :exam="exam"></send-notification-email-button>
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
    import SendNotificationEmailButton from "./send-notification-email-button";
    import ConfirmationModal from "../../modals/confirmation-modal";
    import Payload from '../../../../models/Payload';
    import * as aTypes from '../../../../store/action-types'

    export default {
        name: "send-notification-email-control",

        components: { ConfirmationModal, SendNotificationEmailButton },

        props: [ 'exam' ],

        data: function () {
            return {
                isModalVisible: false,
                modalTitle:  "Send emails to students for accessing their feedback and grade?",

                modalText: "Are you sure? \n Clicking this will immediately send access keys to students for viewing their comments and grades. ",

                options: {
                    displayText: {
                        grant: "",
                        remove: ""
                    },
                    label: '----- Not yet working------',

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

</style>