/**
 * This is a wrapper to help use store
 * to replace $broadcast and $dispatch methods
 * whenever we get around to upgrading to vue 2.0
 * */


/**
 * Replacement for the old broadcast behavior
 * @param eventName
 * @param payload
 */
export const $broadcast = function (eventName, payload) {
    this.$emit(eventName, payload)
};

/**
 * Replacement for the old dispatch behavior
 * @param eventName
 * @param payload
 */
export const $dispatch = function (eventName, payload) {
    this.$emit(eventName, payload)
};

/**
 * Wrapper for listener initialization
 * @param eventName String name of the event
 * @param callback The function to run on the payload
 */
export const listen = function (eventName, callback) {
    this.$on(eventName, function () {
        return callback();
    });
};
