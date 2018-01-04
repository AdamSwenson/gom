<template>
    <div class="box">
        <h4 class="title is-4">{{ name }}</h4>

        <div class="columns">

            <div class="column comments-area">
                <item-comment
                        :item="item"
                        :student="student"
                ></item-comment>

                <div v-for="e in elements">
                    <item-comment
                            :item="e"
                            :student="student"
                    ></item-comment>
                </div>
            </div>

            <div class="column charts-area">
                <item-chart
                        :item="item"
                        :exam="exam"
                        :student="student"
                ></item-chart>

                <div v-for="e in elements">
                    <item-chart
                            :item="e"
                            :exam="exam"
                            :student="student"
                    ></item-chart>
                </div>

            </div>
        </div>

    </div>

</template>

<style lang="scss">

</style>

<script>
    import * as nggTypes from '../../../store/modules/newgrading/new-grading-getter-types';

    import ItemComment from "./item-comment";
    import ItemChart from "./item-chart";

    export default {

        props: [ 'exam', 'item', 'student' ],

        components: {
            ItemChart,
            ItemComment
        },

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {        //the associated child items
            elements: function () {
                let els = [ this.item ];
                if ( !_.isUndefined( this.item ) && !_.isNull( this.item ) ) {
                    let level = 0;
                    let c = this.$store.getters.getItemChildren( this.item );
                    // _.forEach(c, function(d){
                    //    els.push(c);
                    // });
                }
                return els;
            },

            name: function () {
                // return this.item.name;
                if ( !_.isUndefined( this.item ) && !_.isNull( this.item ) ) {
                    return this.item.name
                }
                return '';
            },

        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>