/**
 * Created by adam on 6/30/17.
 */

const ID_WAIT_TIMEOUT = 5000;
const POLL_TIMEOUT = 100;


export const holdForIdLoading = ( item ) => {
    if ( item.id >= 0 ) return true;

    if ( !holdForIdLoading.timeWaited ) holdForIdLoading.timeWaited = 0;
    window.console.log( 'requests', 'holdForIdLoading', 12, item.id, holdForIdLoading.timeWaited );

    while (item.id === -1 && holdForIdLoading.timeWaited <= ID_WAIT_TIMEOUT) {
        holdForIdLoading.timeWaited += POLL_TIMEOUT;
        setTimeout( holdForIdLoading( item ), POLL_TIMEOUT );
    }

    //error message if timed out
    if ( holdForIdLoading.timeWaited === ID_WAIT_TIMEOUT ) throw new Error( "Wait for item id timed out ", item );

    //Now that the loop is done for this item, reset time waited
    if ( item.id >= 0 ) holdForIdLoading.timeWaited = 0;

    //Return boolean
    return item.id >= 0;
};


export const holdForCanSync = ( getters ) => {
    //return true if syncable since no need to wait
    if ( getters.canSync ) return true;

    //otherwise we need to wait
    let timeWaited = 0;
    let keepWaiting = ( getters, waited ) => {
        window.console.log( 'apiHelpers', 'keepWaiting', 38, waited);
        //check whether we've hit the limit, if so, stop
        if ( waited >= ID_WAIT_TIMEOUT ) return false;
        //enter a loop waiting for it to change
        while (getters.canSync || waited <= ID_WAIT_TIMEOUT) {
            waited += POLL_TIMEOUT;
            setTimeout( (waited)=>{return keepWaiting(waited);}, POLL_TIMEOUT );
        }
        window.console.log( 'apiHelpers', 'keepWaiting', 45, waited);
        return getters.canSync;
    };

    return keepWaiting( getters, timeWaited );

};

