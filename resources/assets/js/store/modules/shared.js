/**
 * These are functions and objects which the various
 * modules may share.
 *
 * Created by adam on 1/17/17.
 */

export const isDefined = (val) => {
    if(typeof val != 'undefined'){
        return true;
    }
    return false;
}