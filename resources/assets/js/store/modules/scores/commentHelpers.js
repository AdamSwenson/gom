/**
 * Created by adam on 12/19/18.
 * These are tools for handling the comments
 * and scores
 */


/*
 * Set valenceCutoffs for comments --  these represent the maximum value for each valence group.
 * Magic numbers for now, but will accept data from the server for valenceCutoffs, valenceLabels and valenceLabelPositions
 *
 */
export const sliderSettings = {
    max: 10,
    sliderStep: 0.25,
    /**
     * This gets passed to the slider's ticks option
     * From the docs: Used to define the values of ticks.
     * Tick marks are indicators to denote special values in the range.
     * This option overwrites min and max options.
     */
    valenceCutoffs: [ 0, 3.25, 6.75, 10 ],


    valenceLabels: [ "Missing", "Poor", "Fair", "Excellent" ],

    /**
     * This gets passed to the sliders ticks_position option
     * From the docs: Defines the positions of the tick values in percentages.
     * The first value should always be 0, the last value should always be 100 percent.
     * */
    valenceLabelPositions: [ 0, 33, 67, 100 ]
};





export const checkInRange = ( score, cutoffs ) => {
    if ( score < cutoffs[0] ) throw new Error( "cannot get valence. value out of range" );
    return true;
}


/**
 * Sets currentValence to which valence group a [score] belongs to by comparing with valenceCutoffs[]
 * i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
 *
 * @param score
 * @returns {number}
 */
export function getValenceForScore( score, maxScore ) {
    if ( _.isNull( score ) ) throw new Error( "cannot get valence for null" );

    //if the max score is set, we need to dynamically create
    //the cutoffs. Otherwise we'll use the defaults from the slider settings
    // We start by figuring out how far apart the
    //cutoffs need to be by dividing max possible score by the number of labels
    let numLabels = sliderSettings.valenceLabels.length;

    let cutoffs = (!_.isUndefined( maxScore )) ? makeCutoffsFromMaxScore( maxScore, numLabels) : sliderSettings.valenceCutoffs;

    if ( !checkInRange( score, cutoffs ) ) return null;

    return getValenceIndex( score, cutoffs );
};


export const getValenceIndex = ( score, cutoffs ) => {
    //now we can look up the valence
    let valence = 0;
    //start at the second largest value in the cutoffs.
    for (let j = cutoffs.length - 2; j >= 0; j--) {
        if ( score > cutoffs[ j ] ) {
            //if the score is greater than the second largest cutoff value, then it belongs
            //to the highest valence and so on.
            valence = j + 1;
            break;
        }
    }
    window.console.log( 'commentHelpers', 'getValenceIndex', 81, score, cutoffs, valence);
    //return the set valence. If made it all the way to 0, the default will be returned.
    return valence;
}


/**
 * Check whether the old and new scores have the same valence.
 * If they are, return true.
 * If not or if oldScore wasn't set, return false
 * @param oldScore
 * @param newScore
 * @returns {boolean}
 */
export function isSameValence( oldScore, newScore, maxScore ) {
    //if there was no old score, return false
    if ( typeof oldScore == 'undefined' || oldScore == null ) {
        return false;
    }


    if ( getValenceForScore( newScore, maxScore ) != getValenceForScore( oldScore, maxScore ) ) {
        return false;
    }
    return true;

};


/**
 * Returns a list of equally spaced cutoff values
 * for the given number of labels.
 *
 * The first value will always be 0
 *
 * @param maxScore
 * @param numLabels
 * @returns {Array}
 */
export function makeCutoffsFromMaxScore( maxScore, numLabels ) {
    let cutoffs = [];

    _.forEach(sliderSettings.valenceLabelPositions, function ( vlp ) {
        cutoffs.push( (vlp * .01) * maxScore);
    })
//
// //todo the max score needs to be the final value
//     let intervalVal = maxScore / numLabels;
//     //starting at 0 (for missing), we populate the list
//     for (let i = 0; i < numLabels - 2; i += intervalVal) {
//         cutoffs.push( i );
//     }
//     //the final cutoff should always be the max score
//     cutoffs.push(maxScore);

    return cutoffs;
}
