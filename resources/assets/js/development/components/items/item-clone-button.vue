<style lang="scss">

</style>

<script>

    import * as aTypes from '../../../store/action-types';
    import buttonBase from '../input/button-base';
    import mixin from './item-buttons.mixin';

    export default {
        extends: buttonBase,

        mixins: [ mixin ],

        props: [ 'item' ],


        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            local: function () {
                if ( this.isExam ) {
                    return {
                        buttonText: 'Clone exam',
                        icon: "fa fa-clone",
                        identifyingClass: 'exam-clone-button',
                        linkClass: 'is-primary is-outlined',
                        linkTitle: 'Create a new exam from a copy of this one',
                        screenReaderText: 'Click to copy this exam',
                    }
                }

                //Ordinary item
                return {
                    buttonText: 'Clone',
                    icon: "fa fa-clone",
                    identifyingClass: 'item-clone-button',
                    linkClass: 'is-primary is-outlined',
                    linkTitle: 'Add an exact copy of the present item as its sibling',
                    screenReaderText: 'Click to copy this item',
                }
            },
        },

        methods: {
            handleClick: function () {
                if ( !this.isExam ) {
                    window.console.log( 'item-clone-button', 'handleClick', 53, 'clone item requested');
                    let payload = { parent: this.parentSerialNumber, toClone: this.item };
                    this.$store.dispatch( aTypes.cloneItem, payload );
                }
                else{
                    window.console.log( 'item-clone-button', 'handleClick', 57, 'Clone exam requested');
                }
            }
        },

    }
</script>