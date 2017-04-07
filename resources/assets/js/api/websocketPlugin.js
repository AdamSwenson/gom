/**
 * Created by adam on 4/1/17.
 */

const socketRoute = '';



/**
 * This subscribes a websocket
 * to mutations in the store.
 */
export default function (store) {
    // const socket = new WebSocket('wss:' + socketRoute);


//         // socket.on('data', data => {
//         //     store.commit('receiveData', data)
//         // });
    // called when the store is initialized
    store.subscribe(( mutation, state ) => {
        // called after every mutation.
        // The mutation comes in the format of { type, payload }.
        // window.console.log('websocket subscriber', 'mutation caught', 48, mutation);
    })
};
