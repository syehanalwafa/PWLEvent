import axios from 'axios';

axios.get('http://localhost:5000/api/events')
  .then(response => {
    console.log(response.data); // tampilkan data di console
  })
  .catch(error => {
    console.error(error);
  });
