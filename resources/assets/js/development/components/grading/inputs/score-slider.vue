<template>
    <!-- score slider -->
    <div class="field">
        <label></label>
        <div class="control">
            <input type="text"
                   class="slider"
            >
        </div>
        <p class="help"></p>
    </div>

</template>

<style lang="scss">

</style>

<script>
    var Slider = require( "../../../../libraries/bootstrap-slider-modified.js" );


    export default {

        props: ['item'],

        components: {},

        data: function () {
            return {
                defaults: {
                    settings: {
                        sliderStep: 0.25,
                        valenceCutoffs: [ 0, 3.25, 6.75, 10 ],
                        valenceLabels: [ "Missing", "Poor", "Fair", "Excellent" ],
                        valenceLabelPositions: [ 0, 33, 67, 100 ]
                    }
                }
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