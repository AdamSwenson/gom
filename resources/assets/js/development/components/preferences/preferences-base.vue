<template>

    <div class="preferences-body">
        <div class="tabs">
            <ul>
                <li v-for="t in tabs"
                    v-bind:class="t.name === selected ? 'is-active' : ''"
                    v-on:click="handleClick(t)"
                >
                    <router-link v-bind:to="t.path">
                        <a class="pref-nav">{{t.tabText}} </a>
                    </router-link>
                </li>
            </ul>
        </div>

        <div class="prefs-content">
            <slot name="prefsContent"></slot>

        </div>
    </div>


</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [ 'tabs' , 'defaultRoute'],

        components: {},

        data: function () {
            return {
                selected: this.defaultRoute,
                defaults: {}
            }
        },

        computed: {},

        methods: {

            handleClick: function ( tab ) {
                this.selected = tab.name;
            }
        },

        directives: {},

        events: {},

        mounted: function () {

        }
    }
</script>