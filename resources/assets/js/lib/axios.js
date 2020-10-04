import axios from 'axios';

const customAxios = axios.create({
  // baseURL: process.env.MIX_APP_URL, // habilitar cuando tenga https y hacepte CORS
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

customAxios.interceptors.response.use((response) => {
  return response;
}, error => {
  // asegurarnos que siempre va a un elemento en errors
  !error.response || !!!error.response.data.errors && (error.response.data.errors = [ "Ocurrió un error inesperado" ]);
  return Promise.reject(error);
});

export default customAxios;