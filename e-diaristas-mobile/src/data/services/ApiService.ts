import axios from "axios";

//const url = "https://ediaristas-workshop.herokuapp.com";

// URL nossa API para conexão : 'http://127.0.0.1:8000'

const url = "http://127.0.0.1:8000";

export const ApiService = axios.create({
  baseURL: url,
  headers: {
    "Content-Type": "application/json",
  },
});
