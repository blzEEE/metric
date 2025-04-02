import axios from "./";

export default {
    getServerDate() {
        return axios.get(`/api/server-date`)
    }
};
