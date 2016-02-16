<script type="text/javascript">
    /**
     * Loads the scripts for the page and calls onload when done
     * @param {array} scripts Array of scripts to load
     * @param {onLoad} onLoad Function to call when done loading
     * @param {int} i Counter default = 0
     * @returns {undefined}
     */
    function scriptLoader(scripts, numscripts, onLoad, i) {
        if(numscripts === 1){

            $.getScript(scripts[i]).done(function (data, textStatus) {
                if (textStatus) {
                    onLoad();
                }
            });
        }
        else {
            if (i === numscripts) { //done
                onLoad();
            }
            else {
                $.getScript(scripts[i]).done(function (data, textStatus) {
                    if (textStatus) {
                        i++;
                        scriptLoader(scripts, numscripts, onLoad, i);
                    }
                });
            }
        }
    }
</script>