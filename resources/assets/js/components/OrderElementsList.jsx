import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import OrderElement from './OrderElement';
import $ from 'jquery';

class OrderElementsList extends Component {
    constructor(props) {
        super(props);
        this.state = {
            productTypes: [],
        };
        this.addOrderElement = this.addOrderElement.bind(this);
        this.orderElements = [];
        this.counter = 1;
    }
    componentDidMount() {
        $.ajax({
            url: "http://lenspector.localhost/product-types",
            success: result => {
                const productTypes = result.productTypes;
                this.setState({
                    productTypes: productTypes,
                    numChildren: this.state.numChildren
                });
            }
        });
    }
    addOrderElement() {
        this.counter += 1;
        this.orderElements.push(<OrderElement elementId={this.counter} key={this.counter} productTypes={this.state.productTypes} parent={this} removable={true}/>);
        this.setState(this.state);
    }
    deleteElement(element) {
        for (var i = 0; i < this.orderElements.length; i++) {
            if (this.orderElements[i].props.elementId == element.props.elementId) {
                this.orderElements.splice(i, 1);
                break;
            }
        }
        this.setState(this.state);
    }
    render() {
        return (
            <div className="form-group row">
                <OrderElement elementId={1} key={1} productTypes={this.state.productTypes} parent={this} />
                {this.orderElements}
                <div className="row">
                    <button id="add-diopter-btn" type="button" className="btn btn-default" onClick={this.addOrderElement}>Add element</button>
                    <button type="submit" name="button" className="btn btn-primary">Create</button>
                </div>
            </div>
        );
    }
}

export default OrderElementsList;

if (document.getElementById('OrderElementsList')) {
    ReactDOM.render(<OrderElementsList />, document.getElementById('OrderElementsList'));
}
