

import Payload from "./Payload";

/**
 * This transports data to the confirmation and error modals
 */
export default class PayloadModal extends Payload {

    constructor() {
        super();

        /** Text of the associated comment */
        this.text;

        /** One of 'error' or .... */
        this.type;

        this.closingDelay;

        this.confirmationCallback;
    }

    static get fillableProps() {
        return [
        'confirmationCallback',
        'closingDelay',
            'text',
            'type'
        ];
    }

    static factory( params ) {
        let pt = new PayloadModal();
        return this.fillObject( pt, params );
    }
}