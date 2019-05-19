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
        width: 100%;

        .title-option {
        }

        .select {
            /*width: 100%;*/
        }
    }
</style>

<script>
    import inputSelectorMixin from './input-and-selector.mixin';

    export default {

        mixins: [ inputSelectorMixin ],
        props: [
            'item',
            //which property of the item this represents
            'itemProp',
            /** List of options for the select */
            'options',
            /** whether to display a text area rather than normal text */
            'isTextArea',
            /** for determining things like aria-text */
            'type'
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