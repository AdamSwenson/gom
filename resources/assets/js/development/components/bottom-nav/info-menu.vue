<template>
    <li id="navHelp"
        title="Help"
        role="presentation"
        class="dropdown"
    >
        <a class="dropdown-toggle navItem"
           data-toggle="dropdown"
           href="#"
           role="button"
           aria-haspopup="true"
           aria-expanded="false"
        >
            <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <!--<li>-->
                <!--<a href="{{ url('help') }}">Help</a>-->
            <!--</li>-->
            <!--<li>-->
                <!--<a href="{{ url('info/faq') }}#faq">FAQ</a>-->
            <!--</li>-->
            <!--<li role="separator" class="divider"></li>-->
            <!--<li>-->
                <!--<a href="{{ url('info/instructions') }}">Instructions</a>-->
            <!--</li>-->
            <!--<li>-->
                <!--<a href="{{ url('info/tutorials') }}">Video tutorials</a>-->
            <!--</li>-->
            <!--<li role="separator" class="divider"></li>-->
            <!--<li>-->
                <!--<a href="{{ url('contact') }}">Contact</a>-->
            <!--</li>-->
            <!--<li>-->
                <!--<a href="{{ url('about') }}">About</a>-->
            <!--</li>-->
        </ul>
    </li>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [],

        components: {},

        data: function () {
            return {
                links : [
                    {text: 'Help', link : 'help'},
                    {text: 'FAQ', link : 'info/faq'},
                    {text: 'Instructions', link : 'info/instructions'},
                    {text: 'Video tutorials', link : 'info/tutorials'},
                    {text: 'Contact', link : 'contact'},
                    {text: 'About', link : 'about'},
                   ],

                defaults: {}
            }
        },

        computed: {},

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>