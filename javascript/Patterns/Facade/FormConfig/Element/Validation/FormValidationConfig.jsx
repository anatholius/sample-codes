/**
 * #Konfiguracja walidacji w kontekście formularza
 * ##Role walidacji:
 * - depended - pole formularza jest zależne od innego
 *
 * @property {Object} [...arguments] - typ pola role validacji zdefiniowane obiektami klas ról
 * @see FormDependsRule
 *
 * @description **Warunki walidacji dla formularza:**
 * Każdy argument przekazany do konstruktora klasy powinien być instancją klasy roli
 * see: /App/Api/Component/ValidationRules/*
 */
export default class FormValidationConfig {
    rules = [];
    
    /**
     * Configuration of field validation in the context of the form
     *
     * @param {Object} [arguments] - validation roles defined by role class objects
     */
    constructor() {
        //należy uwzględnić dowolną ilość argumentów/ról
        for (let rule of arguments) {
            this.rules.push(rule);
        }
    }
}