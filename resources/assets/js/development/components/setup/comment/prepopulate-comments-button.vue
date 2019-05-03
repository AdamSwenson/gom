<script>
    import buttonBase from '../../input/button-base';
    import Payload from '../../../../models/Payload'
    import * as aTypes from '../../../../store/action-types';

    export default {
        name: "prepopulate-comments-button",
        extends: buttonBase,

        props: [ 'item', 'haveCommentsBeenCustomized' ],

        data: function () {
            return {
                isWorking: false,
                vars: {
                    buttonText: {
                        default: 'Create rough drafts',
                        working: '------'
                    },
                    icon: {
                        default: "fa fa-eyedropper",
                        working: "fa fa-circle-o-notch fa-spin fa-fw",
                    },
                    syncControl: {
                        noChanges: 'Create comment rough drafts from stock',
                        changes: 'Overwrite existing comments with rough drafts from stock'
                    }
                }
            }
        },

        computed: {
            local: function () {
                return {
                    buttonText:
                        this.isWorking ? this.vars.buttonText.working : this.vars.buttonText.default,

                    helpText: `Changes to the stock text will be used to create rough drafts of the text for the other comments. \n If you have already customized any of these, these changes will replace any customizations you've made.`,

                    icon: this.isWorking ? this.vars.icon.working : this.vars.icon.default,

                    identifyingClass: this.name,

                    linkClass: 'is-warning is-outlined',

                    linkTitle: '',

                    labelText: this.haveCommentsBeenCustomized ? this.vars.syncControl.changes : this.vars.syncControl.noChanges,

                    screenReaderText: "Changes to the stock text will be used to create rough drafts of the text for the other comments. If you have already customized any of these, these changes will replace any customizations you\'ve made.",
                }
            }
        },

        methods: {

            handleClick: function () {

                let comment = this.item.getComment( 'stock' );
                if ( _.isUndefined( comment ) ) return false;

                let me = this;
                me.isWorking = true;

                let pl = Payload.factory( {
                    obj: this.item,
                    updateVal: comment.text
                } );

                this.$store.dispatch( aTypes.prePopulateComments, pl )
                    .then( function () {
                        me.isWorking = false;
                        //tell the parent to refresh the displayed comment
                        me.$emit( 'please-refresh' );
                    } );
            }
        }

    }
</script>

<style scoped>

</style>