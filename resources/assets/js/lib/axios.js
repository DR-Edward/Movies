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
  // asegurarnos que siempre va a tener un message_text
  return Promise.reject(error);
});

export default customAxios;