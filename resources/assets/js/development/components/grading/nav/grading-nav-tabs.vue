<template>
    <div class="tabs">
        <ul >
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

        asyncComputed:{
            questions : function (  ) {
                // return [];
                   return this.$store.getters.getQuestionLevelItems;
            },

            questionRoutes : function (  ) {
                if(_.isUndefined(this.questions) || _.isNull(this.questions)) return [];
                let root = '/grading/question/';
                let routes = [];
                for(let i=1; i<= this.questions.length; i++){
                    routes.push(root + i);
                }
                return routes;
            }

        },
        computed: {

        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>