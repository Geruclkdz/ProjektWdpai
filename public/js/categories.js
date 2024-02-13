const dropdownBtns = document.querySelectorAll('.dropdown-btn');
const dropdownContents = document.querySelectorAll('.dropdown-content');

dropdownBtns.forEach((dropdownBtn, index) => {
    dropdownBtn.addEventListener('click', (event) => {
        const dropdownContent = dropdownContents[index];
        dropdownContent.classList.toggle('show');
    });

    const checkboxes = dropdownContents[index].querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', (event) => {
            const categoryId = checkbox.id;
            const videoId = checkbox.closest('.video').id;

            if (checkbox.checked) {
                addCategory(videoId, categoryId);
            } else {
                deleteCategory(videoId, categoryId);
            }
        });
    });
});

function addCategory(videoId, categoryId) {
    fetch(`/addCategoryToVideo/${videoId}/${categoryId}`)
        .then(function (response) {
            return response.json();})
}

function deleteCategory(videoId, categoryId) {
    fetch(`/removeCategoryFromVideo/${videoId}/${categoryId}`)
        .then(function (response) {
            return response.json();})
}

var selectedCategories = [];

function filterVideos() {
    var videos = document.querySelectorAll('.video');

    videos.forEach(function(video) {
        var hasAllCategories = selectedCategories.every(function(category) {
            return Array.from(video.querySelectorAll('input[type="checkbox"]'))
                .some(function(checkbox) {
                    return checkbox.checked && checkbox.labels[0].innerText.trim() === category;
                });
        });

        video.style.display = (selectedCategories.length === 0 || hasAllCategories) ? 'block' : 'none';
    });
}

// Add event listeners to category buttons to toggle the filter
document.querySelectorAll('.categories button').forEach(function(button) {
    button.addEventListener('click', function() {
        var categoryName = button.innerText.trim();
        var isCurrentlySelected = button.classList.contains('selected');
        button.classList.toggle('selected', !isCurrentlySelected);

        // Update the array of selected categories based on the button's state
        if (isCurrentlySelected) {
            selectedCategories = selectedCategories.filter(category => category !== categoryName);
        } else {
            selectedCategories.push(categoryName);
        }

        filterVideos();
    });
});
