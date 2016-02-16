/**
 * Created by adam on 2/12/16.
 */


var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require('bootstrap');

module.exports = function () {

    /**
     * Sets one of the nav tabs as active. Uses variable which should be set
     * ahead of time on each page
     * @param activeTab id of tab to make active
     */
    function setActiveNavTab( activeTab ) {
        if(activeTab){
            $( '[id^="nav"]' ).attr( 'class', '' );
            $( '#' + activeTab ).attr( 'class', 'active' );
        }
    }

    setActiveNavTab(activeTab);
}