<template>
    <div class="grading-nav-tabs tabs">
        <ul>

            <router-link
                    v-for="r in questionRoutes"
                    tag="li"
                    v-bind:to="r.route"
                    v-bind:key="r.route"
                    v-bind:active-class="activeClass"
            >
                <a>Q{{r.number}}</a>
            </router-link>
        </ul>
    </div>
</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [],

        components: {},

        data: function () {
            return {
                linkClass: 'grading-question-nav',
                activeClass: 'is-active',
                defaults: {},
            }
        },

        asyncComputed: {
            questions: function () {
                return this.$store.getters.getQuestionLevelItems;
            },

            /**
             * String representations of the routes to each
             * question grading panel
             */
            questionRoutes: function () {
                if ( _.isUndefined( this.questions ) || _.isNull( this.questions ) || this.questions.length === 0 ) return [];

                let routes = [];
                for (let i = 0; i <= this.questions.length; i++) {
                    let q = this.questions[ i ];
                    if ( q ) {
                        routes.push( { number: i, route: this.getRoute( q.serialNumber ) } );
                    }
                }
                //notify the parent of what the default route is supposed to be
                this.$emit( 'set-default-question-tab-route', routes[ 0 ].route );

                return routes;

            },

        },
        computed: {},

        methods: {

            /**
             * Constructs a string of the route
             * @param serialNumber
             * @returns {string}
             */
            getRoute: function ( serialNumber ) {
                let root = '/grading-questions/';
                return root + serialNumber;
            },
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>