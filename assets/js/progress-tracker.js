const axios = require('axios').default;
const trackerContentEl = document.getElementById("tracker-content");
module.exports = {
    init: () => {
        axios.get('/api/tasks').then(response => {
            console.log(response.data);
            trackerContentEl.innerHTML = response.data;
        });
        console.log("init");
    }
};