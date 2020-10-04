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
    this.printer = function(err) {
        console.error(err);
        const errors = err.response.data.errors ? Object.values(err.response.data.errors).flat() : [ "Ocurrió un error inesperado" ];
        errors.forEach(error => {
        alertify.error(error);
      });
    }
  }

  /**
    * get index information
    * @author Edward Delgado
    * @param String route
    * @param Object config
  */      
  index(route, config = {}){
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
  store(route, config){
    return this.axios.post(route, config)
    .then(res => res)
    .catch(err => this.printer(err));
  }

  /**
    * get element information
    * @author Edward Delgado
    * @param String route
  */      
  show(route){
    return this.index(route)
  }

    /**
    * store information
    * @author Edward Delgado
    * @param String route
    * @param Object config
  */      
  update(route, config){
    return this.axios.put(route, config)
    .then(res => res)
    .catch(err => this.printer(err));
  }

}