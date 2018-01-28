<template>
    <div id="master-page">

        <div class="container is-fluid">
            <router-view name="masterViewArea"></router-view>
        </div>

        <div class="">
            <sync-indicator></sync-indicator>
        </div>


        <input type="hidden" id="examId" v-model="examId"/>
    </div>


</template>

<style lang="scss">
    /*@import '../../sass/development/newSetup';*/

    .main {
        background-image: linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);
    }

</style>
<script>

    import Exam from '../models/Exam'
    import Item from '../models/Item'
    import Payload from '../models/Payload'

    import * as aTypes from '../store/action-types'
    import * as mTypes from '../store/mutation-types'
    import * as gTypes from '../store/getter-types'

    import { updateItemsOrder } from '../api/requests'
    import { loadKumiForExam } from '../api/requests/kumiRequests';
    import { loadAllStudents } from '../api/requests/studentRequests';

    export default {

        data: function () {
            return {

                defaults: {},
            };
        },

        watch: {
            canSync: function ( newVal, oldVal ) {
                window.console.log( 'new-setup', 'canSync', 118, newVal, oldVal );
                //if the can Sync is newly true, call update
                if ( newVal ) updateItemsOrder( this.$store );
            }
        },

        computed: {},

        methods: {},

        directives: {},

        events: {},

        created: function () {
//             this.$store.commit( mTypes.loadInitialData );
//             let me = this;
//
//             let p = loadExamKumi( this.$store, this.exam );
//             p.then( function () {
//                 //set the first kumi as the one to display
//                 //this needs to happen before associate exam is called
// //                me.$store.commit( 'updateSelectedKumi' );
//                 loadAllStudents( me.$store, me.exam );
//             } );
//
//             //Tags for the items loaded
//             //Does not load tags that aren't yet used on the
//             //exam. That is done on the tags-panel creation
//             //todo this is probably unnecessary
//             this.$store.dispatch( 'processTagsOutOfLoadedItems' );

        },


    }
</script>
