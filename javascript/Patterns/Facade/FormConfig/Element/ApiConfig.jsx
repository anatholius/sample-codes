/**
 * @property {string} action
 */
export default class ApiConfig {
    /** @type {string} - nazwa akcji */
    action = "";
    
    /**
     * @param {string} akcja
     */
    constructor(action) {
        this.action = action;
    }
    
}