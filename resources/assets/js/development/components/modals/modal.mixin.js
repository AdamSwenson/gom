module.exports = {

    computed: {
        /**
         * Whether or not the modal is presently visible
         * @returns {*}
         */
        isModalVisible: function () {
            //If the prop is set, use it
            if ( !_.isUndefined( this.isVisible ) ) return this.isVisible;
                //use the data in the store
                return this.$store.getters[ this.getterNames.visibility ];
         },

        /**
         * Used to control the error modal
         * @param state
         * @returns {boolean}
         */
        isErrorModalVisible: function () {
            return this.$store.getters.isErrorModalVisible;
        },

        /**
         * Used to control the confirmation modal
         * @param state
         * @returns {boolean}
         */
        isConfirmationModalVisible: function () {
            return this.$store.getters.isConfirmationModalVisible;
        },

        /**
         * Gets the PayloadModal object
         * @returns {*}
         */
        modalDataObject: function () {
            let obj = this.$store.getters.getModalData;
            if ( !_.isUndefined( obj ) && !_.isNull( obj ) ) return obj;
            return false;
        },

        /**
         * Body text for the modal
         * @returns {string}
         */
        modalText: function () {
            if ( this.content ) return this.content;

            if ( this.modalDataObject ) return this.modalDataObject.text;

            /**
             * The preferred method of passing in
             * context is via a slot or the modal data in store.
             * But this will
             * work for older uses.
             */
            if ( !_.isUndefined( this.defaults.bodyText ) ) return this.defaults.bodyText;
        },

        /**
         * The type of the modal
         * This will govern the classes used in the modal
         * @returns {binding.getOSType}
         */
        modalType: function () {
            //if the prop is set, use that
            if ( _.isUndefined( this.type ) ) return this.type;

            if ( this.modalDataObject ) return this.modalDataObject.type;
        },

    },

    methods: {
        closeModal: function () {
            this.$store.commit( this.mutationNames.toggleVisibility );

            //for the autoclosing modal, we need to cancel the timer
            if ( !_.isUndefined( this.timer ) && this.timer ) {
                this.overrideDelayTimer()
            }
        },

        handleCancellation: function () {
            window.console.log( 'modal.mixin', 'handleCancellation', 65, this.modalDataObject );
            this.$emit( 'cancel-selected' );
            this.closeModal();
        },

        handleConfirmation: function () {
            window.console.log( 'modal.mixin', 'handleConfirmation', 70, this.modalDataObject );
            //hit the callback provided
            if ( this.modalDataObject ) this.modalDataObject.confirmationCallback();
            this.$emit( 'confirm-selected' );
            this.closeModal();
        }
    }
};