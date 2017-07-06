<template>
    <div class="items-panel panel">
        <p class="panel-heading">
            Items
        </p>

        <div class="panel-block">
            <p class="control has-icons-left">
                <input class="input is-small" type="text" placeholder="Search">
                <span class="icon is-small is-left">
                        <i class="fa fa-search"></i>
                    </span>
            </p>
        </div>


        <p class="panel-tabs">
            <a class="is-active">All</a>
            <a>Ungraded</a>
            <a>Graded</a>
            <a>Tags</a>
        </p>


        <a v-for="obj in items"
           v-on:click="handleRowClick(obj.id)"
           :key="obj.id"
           class="panel-block "
        >
                <span class="panel-icon">
                    <i class="fa fa-book"></i>
                </span>
            {{obj.name}}
        </a>


        <div class="panel-block">
            <button class="button is-primary is-outlined is-fullwidth"
                    v-on:click="handleNew">
                {{ newButtonLabel }}
            </button>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>

    import Item from '../../../models/Item'
    import Exam from '../../../models/Exam'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'


    export default{

        props: [],

        components: {},

        data: function () {
            return {
                newButtonLabel : "New Item",

                defaults: {}
            }
        },

        asyncComputed: {
            items: function () {
                return window.axios
                    .get( 'items' )
                    .then( ( response ) => {
                        window.console.log( 'itemRequests', '', 28, response );
                        let out = [];
                        _.forEach( response.data, function ( r ) {
                            window.console.log( 'existing-items-list', 'r', 80, r);
                            let item = Item.factory( { r } );
                            item.id = r.id;
                            item.name = r.name;
                            item.maxScore = r.max_score;
                            out.push( item );
                        } );
                        return out;
                    } );
            }
        },

        watch: {
            //prob won't need this since there is no reason for the other
            //parts to access the unused items
//            //Once the api has given us the exams, we add them to store
//            //so that others can use them
//            items: function ( newVal, oldVal ) {
//                _.forEach( newVal, ( exam ) => {
//                    let payload = Payload.factory( { obj: exam, mutateSilently: true } );
//                    this.$store.commit( mTypes.addExam, payload );
//                } );
//            }
        },

        computed: {},

        methods: {
            handleRowClick: function (v) {
                window.console.log( 'existing-items-list', 'handleClick', 63,  v);
            },

            handleNew: function(){
                window.console.log( 'existing-items-list', 'handleNew', 106, this);
            },

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>