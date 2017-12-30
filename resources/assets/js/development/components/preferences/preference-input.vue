<template>
    <div class="preference-input ">
        <div class="field is-horizontal" v-if="horizontal">
            <div class="field-label">
                <label class="label">
                    <slot name="labelText"></slot>
                </label>
            </div>
            <div class="field-body">
                <div class="control">
                    <input
                            class="input"
                           v-bind:type="type"
                            v-model="prefValue"
                            v-bind:disabled=" ! available"
                    >
                </div>
                <p class="help has-text-left">
                    <slot name="helpText"></slot>
                </p>
            </div>
        </div>

        <div class="field" v-if="! horizontal">
            <label class="label has-text-left">
                <slot name="labelText"></slot>
            </label>

            <div class="control">
                <input class="input"
                       v-bind:type="type"
                       v-model="prefValue"
                       v-bind:disabled=" ! available"
                >
            </div>
            <p class="help has-text-left">
                <slot name="helpText"></slot>
            </p>
        </div>

    </div>
</template>

<style lang="scss">
    .preference-input {
        margin-bottom: 2em;
    }
</style>

<script>
    export default {

        props: [
            'fieldName',
            'type', //text, number, et cetera
            'available', //whether the option is actually user settable at this time
            'value' //the current value of the setting
        ],

        components: {},

        data: function () {
            return {
                horizontal: false,
                defaults: {}
            }
        },

        computed: {
            prefValue: {
                get: function () {
                    return this.value;
                },
                set: function ( v ) {
                    this.$emit( 'valuechange', {
                        fieldName: this.fieldName,
                        value: v
                    } );
                }
            }
        },

        methods: {
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>