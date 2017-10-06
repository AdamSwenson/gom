<template>
    <div id="sync-indicator"
         class="content"
    >
        <p id="is-syncing-indicator"
           v-if="isSyncing">
            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
            <!--<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>-->
            <span class="sr-only">Syncing...</span>
        </p>

        <p id="no-syncing-indicator" v-else>
            <i class="fa fa-circle-o "></i>
            <span class="sr-only">No sync in progress</span>
        </p>

        <input type="hidden"
               id="isSyncing"
               v-model="isSyncing">
    </div>
</template>

<style lang="scss">
    #sync-indicator {

    }
</style>

<script>

    import Item from '../../../models/Item'
    import Exam from '../../../models/Exam'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'


    //This tells the user when there is a sync w
    //server in progress, and indicates user-fixable
    //errors
    export default {

        //todo Try listening to axios events

        props: [],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            isSyncing: function () {
                return this.$store.getters.isRequestInProgress;
            },

            isError: function () {
                return this.$store.getters.isResponseError;
            }
        },

        methods: {
            setIsSyncing: function () {
                this.isSyncing = true;
            },

            setSyncComplete: function () {
                this.isSyncing = false;
            },


        },

        directives: {},

        events: {
            'sync-started': function () {
                window.console.log( 'server-sync-indicator', 'sync-started', 55, );
            },

            'sync-error': function () {
                window.console.log( 'server-sync-indicator', 'sync-error', 59, );
            },

            'sync-completed': function () {
                window.console.log( 'server-sync-indicator', 'sync-completed', 63, );
            }
        },

        created: function () {
            var me = this;

        }
    }
</script>