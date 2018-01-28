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
                <ul>
                    <li v-for="l in links"
                        class="dropdown-item"
                        v-on:click="handleClick(l)"
                    >
                        <a class="pref-nav">{{l.text}} </a>
                    </li>
                </ul>
            </div>

            <!--<hr class="dropdown-divider">-->

        </div>

        <preference-modal :is-visible="isModalVisible"
                          :type="type"
                          v-on:toggle-modal="toggleModal"
        ></preference-modal>

    </div>

</template>

<style lang="scss">

</style>

<script>

    import { SettingsLinks } from '../../../api/apiSettings';
    import PreferenceModal from "../preferences/preference-modal";

    export default {

        props: [],

        components: { PreferenceModal },

        data: function () {
            return {
                type: '',
                isModalVisible: false,
                links: SettingsLinks,
                defaults: {}
            }
        },

        computed: {},

        methods: {
            toggleModal: function ( v ) {
                this.isErrorModalVisible = !this.isModalVisible;
            },

            handleClick: function ( link ) {
                this.type = link.type;
                this.toggleModal();
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>