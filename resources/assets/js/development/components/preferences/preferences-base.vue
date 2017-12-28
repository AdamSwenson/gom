<template>

    <div class="preferences-body">
        <div class="tabs">
            <ul>
                <li v-for="t in tabs"
                    v-bind:class="t.route == selected ? 'is-active' : ''"
                    v-on:click="handleClick(t)"
                >
                    <router-link
                            v-bind:to="t.route"
                    >
                        <a class="pref-nav">{{t.text}} </a>
                    </router-link>
                </li>
            </ul>
        </div>

        <div class="prefs-content-area">
            <router-view name="prefsContentArea"></router-view>
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
                this.selected = tab.route;
            }
        },

        directives: {},

        events: {},

        mounted: function () {

        }
    }
</script>