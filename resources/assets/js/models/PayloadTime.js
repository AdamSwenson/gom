/**
 * Originally just a transporation class. Now evolving to
 * handle the myriad different ways objects can be identified
 */
import Payload from "./Payload";


export default class PayloadTime extends Payload{
    constructor() {
    super();

    this.exam;
    this.student;
    this.time;
    }

    static get fillableProps() {
        return [
            'exam',
            'student',
            'time'
        ];
    }

    static factory( params ) {
        let pt = new PayloadTime();
        return this.fillObject(pt, params);
    }
}