document.querySelector('.fa-book').addEventListener('click', function () {
    handleIconClick('fa-book');
});

document.querySelector('.fa-user').addEventListener('click', function () {
    handleIconClick('fa-user');
});
document.querySelector('#add_category').addEventListener('click', function () {
    handleIconClick('add_category');
});
function handleIconClick(iconType) {
    switch (iconType) {
        case 'fa-book':
            window.location.href = '/videos';
            break;
        case 'fa-user':
            window.location.href = '/profile';
            break;
        case 'add_category':
            window.location.href = '/addCategory';
            break;
        default:
    }
}

