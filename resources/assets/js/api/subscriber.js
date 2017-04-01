

export function createWebSocketPlugin () {
    return store => {
        // socket.on('data', data => {
        //     store.commit('receiveData', data)
        // });

        store.subscribe(mutation => {
            window.console.log('subscriber', 'mutation caught', 48, mutation.type);
            // if (mutation.type === 'UPDATE_DATA') {
            //     socket.emit('update', mutation.payload)
            // }
        })
    }
}

