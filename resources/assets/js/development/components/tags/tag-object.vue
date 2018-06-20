<template>

    <div class="control tag-object"
         v-if="isVisible"
    >
        <div class="tags has-addons">

            <a
                    class="tag is-rounded"
                    v-bind:class="styling"
                    v-on:click="handleClick"
            >{{name}}</a>

            <a
                    class="tag is-rounded is-delete"
                    v-if="showRemove"
                    v-on:click="handleRemove"
            ></a>
        </div>
    </div>
    <!--</div>-->

    <!--<div class="tag-object"-->
    <!--&gt;-->
    <!--<div v-on:click.stop="toggleTextDisplay" class="control">-->
    <!--<div class="tags has-addons">-->
    <!--<span class="tag is-rounded"-->
    <!--v-bind:class="styling"-->
    <!--&gt;{{name}}</span>-->
    <!--&lt;!&ndash;<a class="tag is-delete  is-small" v-on:click="handleDeleteClick(tag)"></a>&ndash;&gt;-->
    <!--</div>-->
    <!--</div>-->

    <!--<div v-if="isTextVisible"-->
    <!--class="notification is-primary"-->
    <!--&gt;-->
    <!--<button class="delete" v-on:click="toggleTextDisplay"></button>-->
    <!--<p>{{text}}</p>-->
    <!--</div>-->

    <!--</div-->
    <!--&gt;-->
</template>

<style lang="scss">

</style>

<script>
    export default {

        /**
         * The instance of models/Tag to display
         */
        props: [ 'tag', 'isVisible', 'showRemove' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {

            styling: function () {
                let out = '';
                out += this.priorityStyling;

                //other additions to style
                //can be added here
                return out;
            },

            name: function () {
                return this.tag.name;
            },

            text: function () {
                return this.tag.text;
            },

            priorityStyling: function () {
                if ( !_.isUndefined( this.tag.priority ) && this.tag.priority ) {
                    return this.tag.styleString();
                }

                return 'is-primary';
            }
        },

        methods: {

            toggleTextDisplay: function () {
                window.console.log( 'tag-object', 'toggleTextDisplay', 71, );
                this.isTextVisible = !this.isTextVisible;
            },

            handleClick: function () {
                this.$emit( 'tag-clicked', this.tag );
            },

            handleRemove: function () {
                this.$emit( 'remove-clicked', this.tag );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>