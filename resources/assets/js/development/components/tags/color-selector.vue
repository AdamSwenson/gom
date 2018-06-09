<template>
    <div class="color-selector tags">
    <span v-for="p in priorities"
          class="tag selector-tag"
          v-bind:key="p"
          v-bind:class="styling(p)"
          v-on:click="handleSelection(p)"
    >   </span>
    </div>
</template>

<style lang="scss">
.color-selector{
    .selector-tag{

    }
}
</style>

<script>

    import Tag from '../../../models/Tag';

    export default {

        props: [],

        components: {},

        data: function () {
            return {
                events: {
                  selectionEvent : 'color-selected'
                },
                selectedStyle : '',
                defaults: {}
            }
        },

        computed: {
            priorities: function () {
                return Object.values( Tag.styleMap );
            }
        },

        methods: {
            styling: function ( style ) {
                style += style === this.selectedStyle ? ' is-large' : ' is-medium ';
                return style;
            },

            handleSelection: function ( style ) {
                //store the style so that we
                //can highlight the clicked color
                this.selectedStyle = style;

                //look up the relevant key
                let key = Tag.getStyleKey(style);
//                window.console.log( 'color-selector', 'handleSelection', 49, style , key);

                this.$emit( this.events.selectionEvent, key );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>