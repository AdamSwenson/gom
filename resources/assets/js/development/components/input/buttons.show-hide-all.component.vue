<template></template>
<button id="showAll" class="btn btn-default" v-on:click="notifyShowAll">
{{ defaults.displayText.show}}
</button>
<button id="hideAll" class="btn btn-default" v-on:click="notifyHideAll">
    {{ defaults.displayText.hide}}
</button>
<style lang="scss">

</style>
<script>


    import deleteButton from '../items/item-remove-button.vue'
    import panelExamDetail from '../panels/exam-detail-panel.vue'

    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'

    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';


    export default{

        props: [ 'index' ],
        components: {'delete-button': deleteButton},

        data: function () {
            return {
                defaults: {
                    displayText : {
                        hide: 'Hide All',
                        show: 'Show All'
                    }
                }
            }
        },

        computed: {
        },

        methods: {
            notifyHideAll: function (  ) {
                this.$vm.emit('please-hide-all');
            },
            notifyShowAll: function (  ) {
                this.$vm.emit('please-show-all');
            }
        },

        directives: {},

        events: {

        },

        mounted: function () {
        },
    }
</script>