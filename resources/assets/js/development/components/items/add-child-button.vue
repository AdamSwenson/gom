<style>

</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import buttonBase from '../input/button-base';
    import mixin from './item-buttons.mixin';

    export default {
        name: 'add-child-button',

        extends: buttonBase,

        mixins: [ mixin ],

        props: [ 'item' ],

        data: function () {
            return {
                //define the properties of the button

            };
        },

        computed: {
            local: function () {
                return {
                    buttonText: this.localButtonText,
                    icon: "fa fa-list-alt",
                    identifyingClass: 'add-child-button',
                    linkClass: 'is-primary is-outlined',
                    linkTitle: this.localLinkTitle,
                    screenReaderText: this.localScreenReaderText,
                }
            },

            localLinkTitle: function () {
                if ( this.isExam ) return 'Add an item to this exam';
                return 'Add a new item as a child of this item';
            },


            localButtonText: function () {
                if ( this.isExam ) return 'Add Item';
                return 'Add Child';
            },

            localScreenReaderText: function () {
                if ( this.isVisible ) return 'Click to add an item to this exam';
                return 'Click to add a child to this item';
            },

        },

        methods: {
            /**
             * Called on click.
             * It in turn calls a handler
             */
            handleClick: function () {
                // console.log( 'CALLED', 'add', this.serialNumber );
                this.sendRequest();
            },

            /**
             * This sends the actual request(s)
             */
            sendRequest: function () {
                this.$store.dispatch( aTypes.createItem, this.serialNumber );
            }
        },

    }
</script>
