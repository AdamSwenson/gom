<template>
    <div class="tag-object"
    >
        <div v-on:click.stop="toggleTextDisplay" class="control">
            <div class="tags has-addons">
                <span class="tag is-rounded"
                      v-bind:class="styling"

                >{{name}}</span>
                <!--<a class="tag is-delete  is-small" v-on:click="handleDeleteClick(tag)"></a>-->
            </div>
        </div>

        <div v-if="isTextVisible"
             class="notification is-primary"
        >
            <button class="delete" v-on:click="toggleTextDisplay"></button>
            <p>{{text}}</p>
        </div>

    </div
    >
</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [ 'object' ],

        components: {},

        data: function () {
            return {
                isTextVisible: false,
                defaults: {}
            }
        },

        computed: {

            styling: function () {
                let out = '';
                out += this.priority;
                //other additions to style
                //can be added here
                return out;
            },

            name: function () {
                return this.object.name;
            },

            text: function () {
                return this.object.text;
            },

            priority: function () {
                if(! _.isUndefined(this.object.priority) && this.object.priority){
               return this.object.styleString();
                }
//                if ( Object.keys( this.object.props ).indexOf( 'priority' ) > -1 ) {
//                    return this.object.props.priority;
//                }
                return 'is-primary';
            }
        },

        methods: {

            toggleTextDisplay: function () {
                window.console.log( 'tag-object', 'toggleTextDisplay', 71, );
                this.isTextVisible = !this.isTextVisible;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>