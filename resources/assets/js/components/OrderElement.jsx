import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class OrderElement extends Component {
    constructor(props) {
        super(props);
        this.deleteElement = this.deleteElement.bind(this);
    }
    deleteElement() {
        this.props.parent.deleteElement(this);
    }
    render() {
        if (this.props.removable) {
            this.button = <a className="btn btn-danger" onClick={this.deleteElement}>Delete</a>;
        }
        return (
            <div className="diopter-row row">
                <label className="col-form-label col-xs-6 col-md-2" htmlFor="product_type_id[]">Product type</label>
                <div className="col-xs-6 col-md-2">
                    <select name="product_type_id[]" required>
                        {this.props.productTypes.map(type =>
                            <option key={type.id} value={type.id}>{type.name}</option>
                        )}
                    </select>
                </div>
                <label className="col-form-label col-xs-6 col-md-1" htmlFor="quantity[]">Quantity</label>
                <div className="col-xs-6 col-md-2">
                    <input className="form-control" type="number" name="quantity[]" min="1" required/>
                </div>
                <label className="col-form-label col-xs-6 col-md-1" htmlFor="diopter[]">Diopter</label>
                <div className="col-xs-6 col-md-2">
                    <input className="form-control" type="number" name="diopter[]" min="5.0" max="30.0" step="0.5" required/>
                </div>
                {this.button}
            </div>
        );
    }
}

export default OrderElement;

if (document.getElementById('OrderElement')) {
    ReactDOM.render(<OrderElement />, document.getElementById('OrderElement'));
}
