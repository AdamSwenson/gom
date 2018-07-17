<!--<template>-->
    <!--<p class="backup-button field">-->
        <!--<a class="button backup-button is-info is-outlined"-->
           <!--v-on:click="handleClick"-->
           <!--title="Export scores"-->
        <!--&gt;<span class="icon ">-->
            <!--<i class="fa fa-archive" aria-hidden="true">-->
                <!--<span class="sr-only">Export scores to csv file</span>-->
            <!--</i>-->
        <!--</span>-->
        <!--</a>-->
    <!--</p>-->

<!--</template>-->

<style lang="scss">

</style>

<script>

    import NavbarButtonBase from './navbar-button-base';

    export default {
        extends: NavbarButtonBase,

        props: ["exam"],

        components: {},

        data: function () {
            return {
                buttonText: '',
                screenReaderText: 'Export scores to csv file',
                icon: "fa fa-archive",
                linkTitle: 'Export scores',
                linkClass: 'backup-button is-info is-outlined',
                identifyingClass: 'backup-button',

                defaults: {}
            }
        },

        computed: {
            route: function () {
                return window.routeRoot +  '/dev/backup/' + this.exam.id;
            }
        },

        methods: {
            handleClick: function () {
                window.axios({
                    url: this.route,
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'backup.csv');
                    document.body.appendChild(link);
                    link.click();
                });
                // window.axios.get( this.route );
              }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>