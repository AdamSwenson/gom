<template>
    <div class="add-students-panel panel">
        <p class="panel-heading">
            Add students, remove students from class, create classes, see individual grades
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
            <a>Section 1</a>
            <a>Section 2</a>
            <a>Section 3</a>
        </p>

        <a v-for="student in students" class="panel-block ">
                <span class="panel-icon">
                    <i class="fa fa-user"></i>
                </span>
            {{student}}
        </a>


        <div class="panel-block">
            <button class="button is-primary is-outlined is-fullwidth">
                Add students
            </button>
        </div>
    </div>

</template>

<style lang="scss">

    .add-students-panel {

    }

</style>

<script>
    import Comment from '../../../models/Comment'
    import Payload from '../../../models/Payload'
    import Exam from '../../../models/Exam'
    import * as mTypes from '../../../store/mutation-types';
    import * as aTypes from '../../../store/action-types';
    import * as gTypes from '../../../store/getter-types';
    export default{

        props: [],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            //Doing this via computed property so don't have to pass in on route
            isExam: function () {
                if ( this.item instanceof Exam ) return true;
                return false;
            },

            students: function () {
                return [ 'Jill Smith', 'Jill Chen' ];
            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>