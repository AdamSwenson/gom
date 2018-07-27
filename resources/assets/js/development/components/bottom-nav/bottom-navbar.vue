<template>

    <nav id="bottom-navbar"
         class="navbar is-transparent"
         role="navigation"
         aria-label="main navigation"
    >
        <div class="navbar-brand">
            <!-- left side of navbar: navbar items, navbar burger... -->
            <button class="button navbar-burger" data-target="navMenu">
                <span v-for="l in helpLinks"
                      class="navbar-item">
                    <a v-bind:href="l.link">{{ l.text}}</a>
                </span>

                <span v-for="l in businessLinks"
                      class="navbar-item">
                    <a v-bind:href="l.link">{{ l.text}} </a>
                </span>
            </button>
        </div>

        <div class="navbar-menu">
            <!--right side of navbar-->
            <div class="navbar-start">
                <!--left side of navbar menu-->
                <a v-for="l in businessLinks"
                   class="navbar-item"
                   v-bind:href="l.link">{{ l.text}} </a>


            </div>
            <div class="navbar-end">
                <!--right side of navbar menu-->
                <a v-for="l in helpLinks"
                   class="navbar-item"
                   v-bind:href="l.link">{{ l.text}} </a>
            </div>

        </div>

    </nav>
</template>

<style lang="scss">
    /*@import '../../../../sass/development/newGom';*/

    #bottom-navbar {
        a {
            font-weight: bold;
            color: #0f0f0f;
        }

    }
</style>

<script>
    /**
     *

     The navbar component is a responsive and versatile horizontal navigation bar with the following structure:

     navbar the main container
     navbar-brand the left side, always visible, which usually contains the logo and optionally some links or icons
     navbar-burger the hamburger icon, which toggles the navbar menu on touch devices
     navbar-menu the right side, hidden on touch devices, visible on desktop
     navbar-start the left part of the menu, which appears next to the navbar brand on desktop
     navbar-end the right part of the menu, which appears at the end of the navbar
     navbar-item each single item of the navbar, which can either be an a or a div
     navbar-link a link as the sibling of a dropdown, with an arrow
     navbar-dropdown the dropdown menu, which can include navbar items and dividers
     navbar-divider a horizontal line to separate navbar items


     */

    import { InformationLinks, BusinessLinks } from '../../../api/apiSettings';

    export default {

        props: [],

        components: {},

        data: function () {
            return {
                helpLinks: InformationLinks,
                businessLinks: BusinessLinks,
                defaults: {}
            }
        },

        computed: {},

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
            document.addEventListener( 'DOMContentLoaded', function () {

                // Get all "navbar-burger" elements
                var $navbarBurgers = Array.prototype.slice.call( document.querySelectorAll( '.navbar-burger' ), 0 );

                // Check if there are any navbar burgers
                if ( $navbarBurgers.length > 0 ) {

                    // Add a click event on each of them
                    $navbarBurgers.forEach( function ( $el ) {
                        $el.addEventListener( 'click', function () {

                            // Get the target from the "data-target" attribute
                            var target = $el.dataset.target;
                            var $target = document.getElementById( target );

                            // Toggle the class on both the "navbar-burger" and the "navbar-menu"
                            $el.classList.toggle( 'is-active' );
                            $target.classList.toggle( 'is-active' );

                        } );
                    } );
                }

            } );
        }
    }
</script>