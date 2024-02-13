const search = document.querySelector('input[placeholder="search video"]');
const videoContainer = document.querySelector('.videos');

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = { search: this.value };
        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (videos) {
            videoContainer.innerHTML = "";
            loadVideos(videos);
        });
    }
});
function loadVideos(videos) {

    videos.forEach(video => {
        createVideo(video);
    });
}


function createVideo(video) {
    const template = document.querySelector('#video_template');
    const clone = template.content.cloneNode(true);
    const div  = clone.querySelector(".video");
    div .id = video.id;
    const videoTop = clone.querySelector('div');

    const title = clone.querySelector('h2');
    title.textContent = video.title;

    const videoElement = clone.querySelector('video');

    const sourceElement = document.createElement('source');
    sourceElement.src = video.video + "#t=5";

    videoElement.appendChild(sourceElement);
    div.appendChild(videoElement);

    videoContainer.appendChild(clone);
}




