<template>
    <div class="grading-nav-tabs tabs">
        <ul>
            <li v-for="r in questionRoutes"
                role="presentation"
                class="grading-nav-link"
                v-bind:class="[selectedNumber === r.number ? activeClass : '']"
            >
                <router-link v-bind:to="r.route">
                    <a class="grading-question-nav"
                       v-on:click="handleClick(r.number)"
                    > Q{{r.number}} </a>
                </router-link>
            </li>
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
                activeClass: 'is-active',
                selectedNumber: 0, //assumes always initially shows the q0
                defaults: {}
            }
        },

        asyncComputed: {
            questions: function () {
                // return [];
                return this.$store.getters.getQuestionLevelItems;
            },


            questionNumbers: function () {
                if ( _.isUndefined( this.questions ) || _.isNull( this.questions ) || this.questions.length === 0 ) return [];

                let r = [];
                for (let i = 0; i <= this.questions.length; i++) {

                    // r.push( { number: i, route: this.getRoute(this.questions[i].serialNumber) } );

                    r.push( i );
                }
                return r;
            },

            questionRoutes: function () {
                if ( _.isUndefined( this.questions ) || _.isNull( this.questions ) || this.questions.length === 0 ) return [];

                let routes = [];
                for (let i = 0; i <= this.questions.length; i++) {
                    let q = this.questions[ i ];
                    if ( q ) {
                        routes.push( { number: i, route: this.getRoute( q.serialNumber ) } );
                    }
                }
                return routes;
            }

        },
        computed: {},

        methods: {
            handleClick: function ( number ) {
                this.selectedNumber = number;
            },
            getRoute: function ( serialNumber ) {
                let root = '/grading-questions/';
                return root + serialNumber;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>