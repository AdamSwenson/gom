<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import buttonBase from '../input/button-base';
    import mixin from './item-buttons.mixin';

    export default {
        name: 'add-sibling-button',
        extends: buttonBase,

        mixins: [ mixin ],

        props: [ 'item', 'type' ],

        data: function () {
            return {
                //define the properties of the button
                local: {
                    buttonText: 'Add Sibling',
                    icon: "fa fa-plus",
                    identifyingClass: 'add-sibling-button',
                    linkClass: 'is-primary is-outlined',
                    linkTitle: 'Add a new item with the same parent as this item ',
                    screenReaderText: 'Click to add a sibling of this item',
                }
            };
        },

        computed: {},

        methods: {
            /**
             * Called on click.
             * It in turn calls a handler
             */
            handleClick: function () {
                // console.log( 'CALLED', 'sibling', this.serialNumber );
                this.sendRequest();
            },

            /**
             * This sends the actual request(s)
             */
            sendRequest: function () {
                this.$store.dispatch( aTypes.createItem, this.parentSerialNumber );
            }
        },

    }
</script>
