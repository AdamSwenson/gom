<template>
    <a
            class="exam-panel-close-control button"
            v-on:click="handleClick"
    >
         <span class="icon is-small">
             <i v-bind:class="useIcon" aria-hidden="true"></i>
         </span>
    </a>

</template>

<script>

    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'
    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'


    export default {
        name: "exam-panel-close-control",

        data: function () {
            return {
                downIcon: 'fa fa-chevron-down',
                upIcon: 'fa fa-chevron-up',
                useIcon: 'fa fa-times',
            }
        },

        methods: {
            handleClick: function () {
                // this.useIcon = this.upIcon;
                this.$store.commit( mTypes.toggleExamSettings, Payload.factory( { mutateSilently: true } ) );
                //remove the active class
                this.$router.replace( '/' );
                // this.useIcon = this.downIcon;

            }
        }
    }
</script>

<style scoped>

</style>