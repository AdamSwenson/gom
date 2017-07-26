<template>
    <div id="sync-indicator" class="box">
        <p id="is-syncing-indicator" v-if="isSyncing">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Syncing...</span>
        </p>
        <p id="no-syncing-indicator" v-else>
            <i class="fa fa-circle-o "></i>
            <span class="sr-only">No sync in progress</span>
        </p>

    </div>
</template>

<style lang="scss">
    #sync-indicator {

    }
</style>

<script>
    //This tells the user when there is a sync w
    //server in progress, and indicates user-fixable
    //errors
    export default {

        //todo Try listening to axios events

        props: [],

        components: {},

        data: function () {
            return {
                isSyncing: false,
                isError: false,
                defaults: {}
            }
        },

        computed: {},

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

        mounted: function () {
        }
    }
</script>