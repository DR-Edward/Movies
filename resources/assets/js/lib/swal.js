import swal from 'sweetalert';

/**
 * Make sweetalert alerts
 * @author Edward Delgado
 * @param Object config
*/
class swalGenerator {
  constructor() {
    this.config = {
      title: "¿Estás seguro?",
      text: "",
      icon: "warning",
      buttons: true,
      dangerMode: true
    };
  }

  async confirmation(config = this.config) {
    return await swal(config);
  };
};

export default swalGenerator;
