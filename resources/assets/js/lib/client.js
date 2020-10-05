/**
 * Make axios requests
 * @author Edward Delgado
 * @param {any} 
 */

import customAxios from './axios';
import alertify from 'alertifyjs';
export default class Client {
  constructor() {
    this.axios = customAxios;
    this.printer = function (err) {
      console.error(err);
      const errors = Object.values(err.response.data.errors).flat();
      errors.forEach(error => alertify.error(error));
    }
  }

  /**
    * get index information
    * @author Edward Delgado
    * @param String route
    * @param Object config
  */
  index(route, config = {}) {
    return this.axios.get(route, config)
      .then(res => res)
      .catch(err => this.printer(err));
  }

  /**
    * store information
    * @author Edward Delgado
    * @param String route
    * @param Object config
  */
  store(route, config) {
    return this.axios.post(route, config)
      .then(res => res)
      .catch(err => this.printer(err));
  }

  /**
    * get element information
    * @author Edward Delgado
    * @param String route
  */
  show(route) {
    return this.index(route)
  }

  /**
    * update all element information
    * @author Edward Delgado
    * @param String route
    * @param Object config
  */
  update(route, data) {
    return this.axios.put(route, data)
      .then(res => res)
      .catch(err => this.printer(err));
  }

  /**
    * update one element field
    * @author Edward Delgado
    * @param String route
    * @param Object config
  */
  patch(route, data) {
    return this.axios.patch(route, data)
      .then(res => res)
      .catch(err => this.printer(err));
  }

  /**
    * delete information
    * @author Edward Delgado
    * @param String route
    * @param Object config
  */
  delete(route, config) {
    return this.axios.delete(route, config)
      .then(res => res)
      .catch(err => this.printer(err));
  }

}