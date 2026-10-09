import '@/bootstrap';
// import { isLogged, setLogged } from '@/utils/auth';

// Create axios instance
const service = window.axios.create({
  baseURL: process.env.MIX_BASE_API,
  timeout: 10000, // Request timeout
});

// Request intercepter
service.interceptors.request.use(
  config => {
    // const token = isLogged();
    // if (token) {
    //   config.headers['Authorization'] = 'Bearer ' + isLogged(); // Set JWT token
    // }
    return config;
  },
  error => {
    // Do something with request error
    console.log(error); // for debug
    Promise.reject(error);
  }
);

// response pre-processing
service.interceptors.response.use(
  response => {
    // if (response.headers.authorization) {
    //   setLogged(response.headers.authorization);
    //   response.data.token = response.headers.authorization;
    // }

    return response.data;
  },
  error => {
    let errorMessage = error.response.data

    if (errorMessage.message)
      errorMessage = errorMessage.message
    // const regex = /Key \(name\)=\((.*?)\) already exists/;
    // const match = errorMessage.match(regex);

    // if (match) {
    //   const duplicateName = match[1];
    //   errorMessage = `The name "${duplicateName}" already exists. Please use another name or edit from the Project section.`;
    // } 

    ElMessage({
      message: errorMessage,
      type: 'error',
      duration: 5 * 1000,
    });
    return Promise.reject(error);
  }
);

export default service;
