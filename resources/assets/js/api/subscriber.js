/**
 * Subscribes to events broadcast by server
 * Created by adam on 3/20/17.
 */
import Echo from "laravel-echo"

const listener = {
    publicChannelEventHandler: ( event ) => {

    },

    privateChannelEventHandler: ( event ) => {
    },

    ready: function(){
        window.Echo = new Echo( {
            broadcaster: 'pusher',
            key: 'your-pusher-key',
            cluster: 'eu',
            encrypted: true
        } );

        //public channel listener
        Echo.channel( 'orders' )
            .listen( 'OrderShipped', ( e ) => {
                console.log( e.order.name );
            } );

        Echo.private( 'private-channel' )
        // .listen(...)
        // .listen(...)
            .listen( 'item-created', ( event ) => {
                console.log( event );
                listener.privateChannelEventHandler( event );

            } );

    }
}


