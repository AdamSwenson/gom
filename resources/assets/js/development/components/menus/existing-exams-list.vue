<!--This can be used in a modal or other menu to select a different exam to do stuff to-->
<template>
    <div class="exams-panel panel">
        <p class="panel-heading">
            Exams
        </p>

        <div class="panel-block">
            <p class="control has-icons-left">
                <input class="input is-small" type="text" placeholder="Search">
                <span class="icon is-small is-left">
                        <i class="fa fa-search"></i>
                    </span>
            </p>
        </div>

        <a v-for="exam in exams"
           v-on:click="showExam(exam.id)"
           :key="exam.id"
           class="panel-block ">
                <span class="panel-icon">
                    <i class="fa fa-book"></i>
                </span>
            {{exam.name}}
        </a>


        <div class="panel-block">
            <button class="button is-primary is-outlined is-fullwidth"
            v-on:click="addExam">
                New Exam
            </button>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    export default{

        props: [],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            exams: function(){
                return [
                    {id: 1, name: 'Exam 1'},
                    {id: 2, name: 'Exam 2'}];
            }
        },

        methods: {
            addExam: function(){

            },
            showExam: function(v){
                window.console.log( 'existing-exams-list', 'showExam', 75, v);

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>