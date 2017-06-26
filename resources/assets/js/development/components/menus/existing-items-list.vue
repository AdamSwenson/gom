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

        <a v-for="obj in objects"
           v-on:click="show(obj.id)"
           :key="obj.id"
           class="panel-block ">
                <span class="panel-icon">
                    <i class="fa fa-book"></i>
                </span>
            {{obj.name}}
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
            objects : function(){
                return [
                    {id: 1, name: 'Item 1'},
                    {id: 2, name: 'Item 2'}];
            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>