<template>
    <div class="preference-toggle ">
        <div class="field is-horizontal" v-if="horizontal">
            <div class="field-label">
                <label class="label">
                    <slot name="labelText"></slot>
                </label>
            </div>
            <div class="field-body">
                <div class="control">
                    <div class="buttons has-addons is-right">
                    <span class="button"
                          v-bind:class=" selected ? 'is-info is-selected' : '' "
                          v-on:click="handleClick"
                    >On</span>
                        <span class="button"
                              v-bind:class="! selected ? 'is-info is-selected' : '' "
                              v-on:click="handleClick"
                        >Off</span>
                    </div>
                </div>
                <p class="help">
                    <slot name="helpText"></slot>
                </p>
            </div>
        </div>

        <div class="field" v-if="! horizontal">
            <label class="label has-text-left">
                <slot name="labelText"></slot>
            </label>

            <div class="control">
                <div class="buttons has-addons ">
                    <span class="button"
                          v-bind:class=" selected ? 'is-info is-selected' : '' "
                          v-on:click="handleClick"
                    >On</span>
                    <span class="button"
                          v-bind:class="! selected ? 'is-info is-selected' : '' "
                          v-on:click="handleClick"
                    >Off</span>
                </div>
            </div>
            <p class="help">
                <slot name="helpText"></slot>
            </p>
        </div>

    </div>
</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [ 'selected' ],

        components: {},

        data: function () {
            return {
                horizontal: false,
                defaults: {}
            }
        },

        computed: {},

        methods: {
            handleClick: function () {
                this.$emit( 'toggled' );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>