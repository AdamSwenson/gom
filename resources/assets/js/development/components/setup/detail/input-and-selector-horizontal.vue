<template>
    <div class="input-and-selector-horizontal field is-horizontal">

        <div class="field-label is-normal">
            <label class="label">
                <slot name="label"></slot>
            </label>
        </div>

        <div class="field-body">
            <div class="field-is-expanded">
                <div class="field"
                     v-bind:class="addonClass"
                >
                    <p v-if="showSelect"
                       class="control"
                    >
                    <span class="select">
                        <select class="ias-select" v-model="selected">
                            <option disabled value="">
                                <slot name="disabledOption"></slot>
                            </option>
                            <option
                                    v-for="o in optionList"
                                    :key="o"
                                    v-bind:value="o"
                            >{{ o }}</option>
                        </select>
                    </span>
                    </p>

                    <p class="control"
                       v-if="! isTextArea"
                    >
                        <input class="input ias-input"
                               name="ias-input"
                               v-bind:aria-label="ariaValue"
                               v-model="inputValueDisplay"
                               v-bind:type="inputType"
                        >
                    </p>

                    <p class="control"
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
                    </p>
                </div>
                <p class="help">
                    <slot name="helpText"></slot>
                </p>
            </div>
        </div>

    </div>
</template>

<style lang="scss">

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

    }
</script>