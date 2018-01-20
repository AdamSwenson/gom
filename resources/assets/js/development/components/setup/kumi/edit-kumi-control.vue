<template>
    <!--<p>-->
    <a class="edit-kumi-button button "
       v-bind:class="styling"
       v-on:click="toggleModalVisibility"
    >
                <!--<span v-if="isEditable">-->
                    <!--<span class="icon"><i class="fa fa-check-circle-o " aria-hidden="true"></i></span>-->
                    <!--<span class="">Edit</span>-->
                    <!--<span class="sr-only">Edit button in selected state</span>-->
                <!--</span>-->

        <!--<span v-else>-->
                    <span class="icon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                    <span class="">{{ buttonLabel }}</span>
                    <span class="sr-only">Edit button in unselected state</span>
                <!--</span>-->


    </a>

    <!--</p>-->

</template>

<style lang="scss">

</style>

<script>
    import KumiEditingModal from "./kumi-editing-modal";

    export default {

        props: [ 'isEditable', 'type', 'isActive', 'isVisible' ],
        components: { KumiEditingModal },

        data: function () {
            return {
                buttonLabel : 'Edit groups',
                buttonStyle: 'button is-outlined is-info', //style when used as button
                tabStyle: 'tab ', //style when used as tab
                isModalVisible: false,
                defaults: {}
            }
        },

        computed: {

            isKumiEditModalVisible : function (  ) {
                return this.$store.getters.isKumiEditModalVisible;
            },

            styling: function () {
                let out = '';
                switch ( this.type ) {
                    case  'tab':
                        out += this.tabStyle;
                        break;
                    case 'button':
                        out += this.buttonStyle;
                        break;
                }

                if ( this.isActive ) out += ' is-active ';

                return out;
            }
        },

        methods: {
            toggleModalVisibility: function (  ) {
                this.$store.commit('toggleEditKumiModal');
//this.isModalVisible = ! this.isModalVisible;
            },
            toggleEditable: function () {
                this.$emit( 'toggleKumiEditable' );
            },

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>