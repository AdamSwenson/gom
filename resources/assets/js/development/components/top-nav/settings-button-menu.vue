<template>
    <div class="dropdown is-hoverable settings-button-menu ">
        <div class="dropdown-trigger">
            <button class="button is-info is-outlined"
                    aria-haspopup="true"
                    aria-controls="dropdown-menu"
            >
                <span class="icon">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </span>
                <!--<span class="icon is-small">-->
                    <!--<i class="fa fa-angle-down" aria-hidden="true"></i>-->
                <!--</span>-->
            </button>
        </div>

        <div class="dropdown-menu" id="dropdown-menu"
             role="menu">
            <div class="dropdown-content">

                <a v-for="l in links"
                   class="dropdown-item"
                v-bind:href="l.link">{{ l.text }}
                </a>

                <!--<hr class="dropdown-divider">-->


            </div>
        </div>
    </div>

</template>

<style lang="scss">

</style>

<script>

    import { SettingsLinks } from '../../../api/apiSettings';

    export default {

        props: [],

        components: {},

        data: function () {
            return {
                links : SettingsLinks,
                defaults: {}
            }
        },

        computed: {
        },

        methods: {
            handleClick: function ( v ) {

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>