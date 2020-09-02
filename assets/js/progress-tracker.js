const axios = require('axios').default;
const trackerContentEl = document.getElementById("tracker-content");

const tracker = {
    init: () => {
        tracker.updateTasksList();

        window.addEventListener('resize', tracker.updateLimitBar);
    },

    updateTasksList: () => {
        axios.get('/api/tasks').then(response => {
            trackerContentEl.innerHTML = response.data;
            tracker.listenForClick();
            tracker.updateLimitBar();
            window.setTimeout(tracker.updateTasksList, 30000);
        });
    },

    updateLimitBar: () => {
        let allUserLineEl = document.querySelectorAll('.user-line');
        let minCompletedTaskId = null;
        let minCompletedElement = null;
        allUserLineEl.forEach(userLine => {
             let allCompleted = userLine.querySelectorAll('.is-complete');
             let lastCompleted = allCompleted[allCompleted.length-1];
             let lastCompletedTaskId = parseInt(lastCompleted.dataset.taskId);
             if (lastCompletedTaskId < minCompletedTaskId || minCompletedTaskId === null){
                 minCompletedTaskId = lastCompletedTaskId;
                 minCompletedElement = lastCompleted;
             }
        });
        console.dir(minCompletedElement);
        console.log(minCompletedTaskId);
        document.getElementById("limit-bar").style.left = minCompletedElement.offsetLeft + minCompletedElement.offsetWidth + "px";
    },

    listenForClick: () => {
        let allMarkers = document.querySelectorAll(".current-user .task-step");
        allMarkers.forEach(marker => {
            marker.addEventListener("click", tracker.markerClicked);
        });
    },

    markerClicked: (e) => {
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