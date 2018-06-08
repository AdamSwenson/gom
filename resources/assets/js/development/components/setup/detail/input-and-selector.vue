<template>
    <div class="input-and-selector field ">

        <label class="label has-text-left">
            <slot name="label"></slot>
        </label>


        <div class="field "
             v-bind:class="addonClass"
        >

            <div v-if="showSelect"
                 class="control"
            >
                    <span class="select">
                        <select class="ias-select"
                                v-model="selected"
                        >
                            <option disabled value="" class="title-option">
                                <slot name="disabledOption"></slot>
                            </option>

                            <option
                                    v-for="o in optionList"
                                    :key="o"
                                    v-bind:value="o"
                            >{{ o }}</option>

                        </select>
                    </span>
            </div>

            <div class="control "
                 v-if="! isTextArea"
            >
                <input class="input ias-input"
                       name="ias-input"
                       v-bind:aria-label="ariaValue"
                       v-model="inputValueDisplay"
                       v-bind:type="inputType"
                >
            </div>

            <div class="control"
                 v-if="isTextArea"
            >
                        <textarea
                                class="textarea ias-input"
                                name="ias-input"
                                v-model="inputValueDisplay"
                                v-bind:aria-label="ariaValue"
                                v-bind:type="inputType"
                                v-bind:numRows="textAreaRows"
                        ></textarea>
            </div>
        </div>

        <p class="help">
            <slot name="helpText"></slot>
        </p>


    </div>
</template>

<style lang="scss">
    .input-and-selector {
        margin: 1em;
        .title-option {
        }
        .select {
            /*width: 100%;*/
        }
    }
</style>

<script>
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload'
    import inputSelectorMixin from './input-and-selector.mixin';

    export default {
mixins: [inputSelectorMixin],
        props: [
            'item',
            'itemProp',
            'options',
            'isTextArea', //whether to display a text area rather than normal text
            'type' //for determining things like aria-text
        ],

        components: {},

        data: function () {
            return {
                selected: '',
                inputValueDisplay: this.item ? this.item[ this.itemProp ] : '',
                textAreaRows: 3,
                defaults: {}
            }
        },
        //
        // watch: {
        //     //I have no idea why this had to be handled like this
        //     //rather than via computed values. Trying it any other way
        //     //led to many different errors....
        //     selected: function ( newVal ) {
        //         this.inputValueDisplay = newVal;
        //     },
        //
        //     inputValueDisplay: function ( newVal ) {
        //         this.handleValueChange( newVal );
        //     }
        // },
        //
        // computed: {
        //     /**
        //      * If we attached a select to the input,
        //      * we need to add a class to the outer field.
        //      * This handles that
        //      */
        //     addonClass: function () {
        //         if ( this.showSelect ) return 'has-addons';
        //     },
        //
        //
        //     /**
        //      * The select options are created from this
        //      */
        //     optionList: function () {
        //         return this.options ? this.options : [];
        //     },
        //
        //     inputType: function () {
        //
        //         switch ( this.type ) {
        //             case 'year':
        //                 return 'number';
        //                 break;
        //             case 'term':
        //                 return 'text';
        //                 break;
        //             default:
        //                 return 'text'
        //         }
        //         ;
        //     },
        //
        //     ariaValue: function () {
        //         return this.inputType + '-input-field';
        //     },
        //
        //     /**
        //      * Whether to display the dropdown select
        //      * @returns {boolean}
        //      */
        //     showSelect: function () {
        //         if ( !_.isUndefined( this.options ) && this.options.length > 0 ) return true;
        //         return false;
        //     }
        //
        // },
        //
        // methods: {
        //     handleValueChange: function ( v ) {
        //         // window.console.log( 'input-and-selector', 'handleValueChange', 153, v );
        //
        //         this.$store.commit( mTypes.updateItem, Payload.factory( {
        //             obj: this.item,
        //             updateProp: this.itemProp,
        //             updateVal: v
        //         } ) );
        //
        //         this.emitUpdateRequest( v );
        //     },
        //
        //     emitUpdateRequest: function ( newValue ) {
        //         return this.$emit( 'update', newValue );
        //     }
        // },
        //
        // directives: {},
        //
        // events: {},
        //
        // mounted: function () {
        // }
    }
</script>