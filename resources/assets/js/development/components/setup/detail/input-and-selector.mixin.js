
import * as mTypes from '../../../../store/mutation-types';
// import gTypes from '../../../../store/getter-types';
import * as nggTypes from '../../../../store/new-grading-getter-types';
import * as ngmTypes from '../../../../store/new-grading-mutation-types';
import * as ngaTypes from '../../../../store/new-grading-action-types';


import Payload from '../../../../models/Payload'

export default {
    watch: {
        //I have no idea why this had to be handled like this
        //rather than via computed values. Trying it any other way
        //led to many different errors....
        selected: function ( newVal ) {
            this.inputValueDisplay = newVal;
        },

        inputValueDisplay: function ( newVal ) {
            this.handleValueChange( newVal );
        }
    },

    computed: {
        /**
         * If we attached a select to the input,
         * we need to add a class to the outer field.
         * This handles that
         */
        addonClass: function () {
            if ( this.showSelect ) return 'has-addons';
        },


        /**
         * The select options are created from this
         */
        optionList: function () {
            return this.options ? this.options : [];
        },

        inputType: function () {

            switch ( this.type ) {
                case 'year':
                    return 'number';
                    break;
                case 'term':
                    return 'text';
                    break;
                default:
                    return 'text'
            }
            ;
        },

        ariaValue: function () {
            return this.inputType + '-input-field';
        },

        /**
         * Whether to display the dropdown select
         * @returns {boolean}
         */
        showSelect: function () {
            if ( !_.isUndefined( this.options ) && this.options.length > 0 ) return true;
            return false;
        }

    },

    methods: {
        handleValueChange: function ( v ) {
            // window.console.log( 'input-and-selector', 'handleValueChange', 153, v );

            this.$store.commit( mTypes.updateItem, Payload.factory( {
                obj: this.item,
                updateProp: this.itemProp,
                updateVal: v
            } ) );

            this.emitUpdateRequest( v );
        },

        emitUpdateRequest: function ( newValue ) {
            return this.$emit( 'update', newValue );
        }
    },

    directives: {},

    events: {},

    mounted: function () {
    }
}