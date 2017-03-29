<template>
    <div id="setupToolDashboard" class="dashboard">

        <ul class="list-group">
            <li class="list-group-item">
                <button
                        class="btn btn-block btn-danger"
                        v-on:click="toggleDeleteMode"
                >Remove</button>
            </li>

            <li class="list-group-item">
                <button
                        class="btn btn-block btn-warning"
                        v-on:click="toggleReorderMode"
                >Reorder</button>
            </li>


            <li class="list-group-item">
                <button
                        class="btn btn-block btn-primary"
                        v-on:click="showSampleFeedback"
                >Sample feedback</button>
            </li>

            <li class="list-group-item">
                <!--replace with toggle-->
                <button
                        class="btn btn-block btn-primary"
                        v-on:click="toggleHolesShown"
                >Highlight holes</button>
            </li>
        </ul>
    </div>
</template>

<style>

</style>
<script>
    /**
     * Created by adam on 2/15/17.
     */

    import * as mTypes from '../../store/mutation-types';

    export default {
        props: [],

        data: function () {
            return {
                /**
                 * Whether to highlight missing or badly ordered items
                 */
                isHolesShown: false
            }
        },

        computed: {

        },

        methods: {
            /**
             * Displays or hides the buttons for removing items
             */
            toggleDeleteMode: function () {
                console.log( 'toggleDeleteMode', 'pressed' );
                this.$store.commit(mTypes.toggleDeleteButtonVisibility)
            },

            toggleReorderMode: function(){
                console.log( 'toggleReorderMode', 'pressed' );
                this.$store.commit(mTypes.toggleReorderMode);
            },

            /**
             * Opens a pop up window for viewing what a student
             * would see, given current settings
             */
            showSampleFeedback: function(){
                console.log( 'showSampleFeedback', 'pressed' );
                this.$store.commit(mTypes.toggleSampleFeedback);
            },

            /**
             * Toggle value of isHolesShown
             */
            toggleHolesShown: function ()
            {
                this.isHolesShown = !this.isHolesShown;
            }

        },

        directives: {},

        events: {},

        mounted: function () {
            console.log( 'tools-dashboard ready' );
        },
    };
</script>
