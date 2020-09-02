const axios = require('axios').default;
const trackerContentEl = document.getElementById("tracker-content");

const tracker = {
    init: () => {
        tracker.updateTasksList();
    },

    updateTasksList: () => {
        axios.get('/api/tasks').then(response => {
            console.log(response);
            trackerContentEl.innerHTML = response.data;
            tracker.listenForClick();
            window.setTimeout(tracker.updateTasksList, 30000);
        });
    },

    listenForClick: () => {
        let allMarkers = document.querySelectorAll(".current-user .task-step");
        console.log(allMarkers);
        allMarkers.forEach(marker => {
            marker.addEventListener("click", tracker.markerClicked);
        });
    },

    markerClicked: (e) => {
        console.log("click");
        let clickedMarker = e.currentTarget;
        let taskId = clickedMarker.dataset.taskId;
        axios.post('/api/tasks/setLastDoneTask', {
            taskId: taskId
        }).then(response => {
            tracker.updateTasksList();
        });
    }
};

module.exports = tracker;