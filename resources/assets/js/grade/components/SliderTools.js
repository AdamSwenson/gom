/**
 * Created by adam on 5/15/16.
 */

module.exports = {
    /*
     * Set valenceCutoffs for comments --  these represent the maximum value for each valence group.
     * Magic numbers for now, but will accept data from the server for valenceCutoffs, valenceLabels and valenceLabelPositions
     *
     */
    settings: {
        sliderStep: 0.25,
        valenceCutoffs: [ 0, 3.25, 6.75, 10 ],
        valenceLabels: [ "Missing", "Poor", "Fair", "Excellent" ],
        valenceLabelPositions: [ 0, 33, 67, 100 ]
    },

    /**
     * Returns which valence group a [score] belongs to by comparing with valenceCutoffs[]
     * i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
     * @param score
     * @returns {number}
     */
    getValence: function ( score ) {
        var valence = 0;
        var me = this;

        //TODO Decide what should do if this gets null for the score

        for ( var j = me.settings.valenceCutoffs.length - 2; j >= 0; j -- ) {
            if ( score > me.settings.valenceCutoffs[ j ] ) {
                valence = j + 1;
                break;
            }
        }
        return valence;
    },

    /**
     * Check whether the old and new scores have the same valence.
     * If they are, return true.
     * If not or if oldScore wasn't set, return false
     * @param oldScore
     * @param newScore
     * @returns {boolean}
     */
    isSameValence: function( oldScore, newScore){
        //if there was no old score, return false
        if(typeof oldScore == 'undefined' || oldScore == null){
            return false;
        }
        if( this.getValence( newScore ) != this.getValence( oldScore )){
            return false;
        }
        return true;
    }
};