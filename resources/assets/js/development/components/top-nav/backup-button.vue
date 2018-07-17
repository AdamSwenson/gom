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
                    //the server should've sent a reasonable filename as a header
                    let filename = !_.isUndefined(response.headers.filename) ? response.headers.filename : 'score-backup.csv';
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', filename);
                    // document.body.appendChild(link);
                    link.click();
                    window.URL.revokeObjectURL(url);

                    window.console.log( 'backup-button', 'headers', 66, response.headers);
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