<template>
    <button
            class="public-indicator button is-outlined "
            v-bind:class="displayClass"
            v-on:click="togglePublic"
    >
       <span class="icon is-small">
           <i v-bind:class="icon" aria-hidden="true"></i>
       </span>
        <span>Visibility</span>
    </button>

</template>
<style>

</style>
<script>
    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as aTypes from '../../../store/action-types'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    /**
     * This is the indicator which tells the user whether the thing it
     * is attached to is visible to the public.
     * On being clicked it emits an event and listens for a request
     * to change from public to hidden or vice versa.
     *
     * This can be used for anything potentially public.
     * That is, it can be used by:
     *      Exam
     *      ExamName
     *      Question
     *      QuestionName
     *      Element
     *      ElementName
     *      Comment
     *
     * Created by adam on 2/17/17.
     */
    export default {

        props: [ 'index' , 'serialNumber'],

        data: function () {
            return {
                styles: {
                    public: 'is-warning',
                    private: 'is-primary'
                },

                icons: {
                    eye: {
                        open: 'fa fa-eye',
                        close: 'fa fa-eye-slash'
                    }
                }
            };
        },

        computed: {
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            //Doing this via computed property so don't have to pass in on route
            isExam: function () {
                if ( this.item instanceof Exam ) return true;
                return false;
            },

            publicity: function () {
                let item = this.$store.getters[ gTypes.getItemByIndex ]( this.index );
                if ( typeof item !== 'undefined' ) {
                    return item.isPublic();
                }
            },

            /**
             * This alters the styling of the indicator
             * to help highlight the possibility that others
             * may see the thing it is attached to
             * @returns {string}
             */
            displayClass: function () {
                return this.publicity ? this.styles.public : this.styles.private;
            },


            icon: function () {
                if ( this.publicity ) {
                    return this.icons.eye.open;
                }
                return this.icons.eye.close;
            },

        },

        methods: {
            /**
             * Returns boolean for whether the thing
             * this is attached to is visible to students
             * (or potentially others, if there was a use).
             * @returns {*}
             */
            isPublic: function () {
                let item = this.$store.getters.getItemBySerialNumber( this.serialNumber );
                // let item = this.$store.getters.getItemByIndex( this.index );
                if ( typeof item !== 'undefined' ) {
                    return item.isPublic();
                }
            },

            /**
             * Returns boolean for whether the thing
             * this is attached to is hidden from students
             * (or potentially others, if there was a use).
             * Just a semantically useful shortcut
             * @returns {*}
             */
            isPrivate: function () {
                return !this.isPublic;
            },

            /**
             * Called when the indicator is clicked.
             * It subsequently calls other functions to
             * do the work.
             */
            togglePublic: function () {
//                console.log( 'CALLED', 'togglePublic' );
                this.$store.dispatch( aTypes.toggleItemPublic, Payload.factory( { serialNumber: this.serialNumber } ) );
            },


        }
        ,

        directives: {}
        ,

        events: {}
        ,

        mounted: function () {
        }
        ,
    }
    ;

</script>
