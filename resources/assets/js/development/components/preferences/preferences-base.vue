<template>

    <div class="preferences-base">
        <div class="tabs">
            <ul>
                <li v-for="t in tabs"
                    v-bind:class="t.path === currentPath ? 'is-active' : ''"
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

        props: [ 'tabs' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            currentPath: function () {
                return this.$route.path;
            }
        },

    }
</script>