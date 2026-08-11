import PayloadModal from "../../../../../models/PayloadModal";


// import gTypes from '../../../../store/getter-types';
import * as nggTypes from '../../../../../store/new-grading-getter-types';
import * as ngmTypes from '../../../../../store/new-grading-mutation-types';
import * as ngaTypes from '../../../../../store/new-grading-action-types';


export default {


    computed: {

        /** Whether the error modal is displayed */
        isErrorModalVisible: function () {
            return this.$store.getters.isErrorModalVisible;
        },

        /** Whether the confirmation dialog is displayed*/
        isConfirmationModalVisible: function () {
            return this.$store.getters.isConfirmationModalVisible;
        },

        /** Includes kumiSelectorVisible so that anything in the label
         * can change with the list state
         */
        isKumiSelectorVisible: function () {
            return this.$store.getters.isKumiSelectVisible;
        },

        /**
         * Array of currently selected groups. When
         * an operation button is clicked, these will be part of the
         * payload.
         */
        selectedKumis: function () {
            return this.$store.getters.getSelectedKumis;
        },

        /**
         * Array of currently selected students. When
         * an operation button is clicked, these will be part of the
         * payload.
         */
        selectedStudents: function () {
            return this.$store.getters[nggTypes.getSelectedStudents];
        },


    },


    methods: {

        /**
         * Displays the confirmation window when
         * the button is clicked after performing
         * the check on whether the operation is valid
         */
        handleClick: function () {
            if ( this.isOperationValid ) {
                window.console.log( 'action-buttons.mixin', 'handleClick', 62);

                //open the kumi selector
                if ( this.requiresKumiSelector ) this.$store.commit( 'toggleKumiSelectVisibility' );


                if ( this.requiresConfirmation ) {
                    this.$store.commit( 'toggleConfirmationModal', PayloadModal.factory( {
                        text: this.confirmationModalText,
                        confirmationCallback: this.handleConfirmation
                    } ) );

                } else {
                    //for things like adding to groups we don't
                    //need the user to confirm, so we pretend that
                    //it is confirmed.
                    this.handleConfirmation();
                }
            }
            else {

                this.$store.commit( 'toggleErrorModal', PayloadModal.factory( {
                    type: 'error',
                    text: this.errorModalText
                } ) );

                // this.isErrorModalVisible = true;
            }
        },

        notifyParentOperationIsComplete: function () {
            this.$emit( 'done' );
        },

        /**
         * Dispatches the action defined in this.actionName
         * with the payload defined in this.payload
         */
        handleConfirmation: function () {
            let me = this;
            this.$store.dispatch( this.actionName, this.payload )
                .then( function () {
                    me.resetDisplay();
                } );
        },

        /**
         * Called when cancel is clicked
         */
        handleCancellation: function () {
            this.resetDisplay();
        },


        /**
         * Resets the selected students and kumis to
         * default state. Also hides any displayed menus
         * and clears the pending operation
         */
        resetDisplay: function () {
            //hide the displayed kumi selector
            if ( this.isKumiSelectorVisible ) this.$store.commit( 'toggleKumiSelectVisibility' );

            //clear previous selections
            this.$store.commit( 'clearSelectedStudents' );
            this.$store.commit( 'clearSelectedKumis' );

            //make sure the modals are closed
            //modals should be closed by the store controller

            // this.isConfirmationModalVisible = false;
            // this.isErrorModalVisible = false;
        },


    }
};