<script>
    import buttonBase from '../input/button-base';
    import mixin from './item-buttons.mixin';

    /**
     * This button allows us to use button-base in contexts where
     * we need to pass all the required values via props rather
     * than defining a whole separate component.
     *
     * The handle click method emits the event
     *      button-clicked
     * which the parent component should listen for like this
     *      v-on:button-clicked="handleClick"
     */
    export default {
        name: 'item-button-fillable',

        extends: buttonBase,

        mixins: [ mixin ],

        methods: {
            /**
             * Called on click.
             * It in turn calls a handler
             */
            handleClick: function () {
                this.$emit('button-clicked', {item: this.item, exam: this.exam});
            },

        },

    }
</script>
