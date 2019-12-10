import React from "react";
import * as Helper from "../Helper/Helper";

export default class FormComponent extends React.Component {
    displayName = 'FormComponent';
    _fields;
    _decorators;
    
    constructor(props, context) {
        super(props, context);
        
        this.state = {};
    }
    
    getOutput = () => {
        return (
            <form ref={this.ref[this._configForm.item.name]} id={`${this._configForm.item.name}-form`}
                  data-form={this._configForm.item.name}
                  className="form-store-data form-ajax-submit">
                <div className="list no-margin no-hairlines">
                    <ul>
                        {this._fields.map((field, key) => {
                            const fieldConfig = this._configForm.fields[field];
                            const Widget = this.fieldWidget[Helper.ucfirst(fieldConfig.type) + 'Widget'];
                            return <Widget key={key} field={field} data={this.state}/>
                        })}
                    </ul>
                </div>
            </form>
        );
    };
    
    render() {
        return this.getOutput();
    }

}