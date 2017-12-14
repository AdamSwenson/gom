<template>
    <div class="tabs">
        <ul v-bind:id="id">
            <li v-for="route, i in questionRoutes" style=""
                role="presentation" class=""
            >
                <router-link v-bind:to="route">
                    <a class="grading-question-nav"> Q{{i}} </a>
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
                defaults: {}
            }
        },

        computed: {
            questions : function (  ) {

            },

            questionRoutes : function (  ) {
                let root = '/grading/question/';
                let routes = [];
                for(let i=1; i<= this.questions.length; i++){
                    routes.push(root + i);
                }
                return routes;
            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>