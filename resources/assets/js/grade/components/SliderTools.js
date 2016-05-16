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
        valenceCutoffs: [ 0, 3.25, 6.75, 10 ],
        valenceLabels: [ "Missing", "Poor", "Fair", "Excellent" ],
        valenceLabelPositions: [ 0, 33, 67, 100 ],
        sliderStep: .25
    },

    /**
     * Returns which valence group a [score] belongs to by comparing with valenceCutoffs[]
     * i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
     * @param score
     * @returns {number}
     */
    getValence: function ( score ) {
        var valence = 0;
        for ( var j = this.settings.valenceCutoffs.length - 2; j >= 0; j -- ) {
            if ( score > this.settings.valenceCutoffs[ j ] ) {
                valence = j + 1;
                break;
            }
        }
        return valence;
    }
}