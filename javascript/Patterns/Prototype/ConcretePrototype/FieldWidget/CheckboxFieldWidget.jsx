import React from "react";
import FieldWidgetPrototype from "../FieldWidgetPrototype";

/**
 * @class RadioFieldWidget
 * @memberOf WidgetPrototype
 * @instance
 * @summary [wzorzec: Prototype -> ConcretePrototype -> PrototypeInstance]
 */
export default class CheckboxFieldWidget extends FieldWidgetPrototype {
    displayName = 'CheckboxFieldWidget';
    
    _configureSettings = (props) => {
        const fieldName = props.field;
        const formConfig = this.config.formConfig;
        const formName = formConfig.item.name;
        const fieldConfig = formConfig.fields[fieldName];
        const values = this.config.state.form;
        console.log(`this.config(${fieldName})`, this.config);
        console.log(`props`, props);
        this.settings.name = fieldConfig.name;
        this.settings.label = fieldConfig.label;
        this.settings.placeholder = fieldConfig.placeholder ? fieldConfig.placeholder : fieldConfig.label;
        this.settings.disabled = props.disabled ? props.disabled : false;
        this.settings.defaultValue = values[fieldName];
        
        if (values[fieldName]) {
            this.settings.wrapperClass.push('item-input-with-value');
        }
        if (props.data.errors && props.data.errors[formName][fieldName]) {
            this.settings.data.errorMessage = props.data.errors[formName][fieldName];
            this.settings.wrapperClass.push('item-input-with-error-message item-input-invalid');
        }
        
    };
    
    radioWidget = (props) => {
        console.log('trying to render:', props);
        return <div>dupa checkbox field widget dla {props.field} </div>;
    };
    
}