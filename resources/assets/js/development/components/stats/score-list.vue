<template>
    <div class="score-list">
        <p class="h4"> {{ title }} </p>

        <div class="box">

            <div v-if="isLoading">
                <loading-indicator :is-loading="isLoading"></loading-indicator>
            </div>

            <div v-if="! isLoading">
                <ul class="stat-list">
                    <li v-for="s in scores"> {{ s.score}} </li>
                </ul>
            </div>

        </div>
    </div>

</template>

<style lang="scss">

</style>

<script>
//    import * as aTypes from '../../../../store/action-types';
//    import * as mTypes from '../../../../store/mutation-types';
//    import Payload from '../../../../models/Payload';

    import statsRequests from '../../../api/requests/statsRequests';
    import loadingIndicator from '../helpers/loading-indicator.vue';


    export default {

        props: [
            'exam',
            'item',
            'displayScope'
        ],

        components: {
            'loading-indicator': loadingIndicator,
        },

        data: function () {
            return {

                isLoading: false,

                scoreSortOrder: 'desc',

                /**
                 * This governs what scope of scores we are displaying
                 * it can be initially set via the prop or overwritten
                 * by a user command.
                 * Potential values: exam, all, kumi
                */
                scope: ! _.isUndefined(this.displayScope) ? this.displayScope : 'exam',

                /** Display text for title. Keys are potential values of scope */
                titles: {
                    'all': "Item scores on all exam",
                    'exam': "Item scores on this exam",
                    'kumi': "Item scores for selected group"
                },

                defaults: {}
            }
        },

        asyncComputed: {

            /**
             * Retrieves the raw scores without student information
             */
            scores: function () {
                if ( this.isExam ) return [];

                let me = this;

                //display loading indicator
                me.isLoading = true;

                //this loads the scores into store
                //and returns a promise
                let p = this.getItemScoresForStats( this.$store, this.item );

                //thus when it is complete, we get them from the store
                return p.then( function () {
                    let stats = me.$store.getters.getAnonScoresForItemStats( me.item );
                    //done loading
                    me.isLoading = false;
                    return _.sortBy( stats, 'score', me.scoreSortOrder );
                } );
            }
        },

        computed: {
            title: function (  ) {
                return this.titles[this.scope];
            },


            isExam: function () {
                return this.item ? this.item.isExam() : false;
            }

        },

        methods: {
            ...statsRequests
        },

    }
</script>