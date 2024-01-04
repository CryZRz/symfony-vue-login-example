import axios from "axios";

const clientAuthFetch = axios.create({
    baseURL: process.env.VUE_APP_API_URL,
})

export {clientAuthFetch}