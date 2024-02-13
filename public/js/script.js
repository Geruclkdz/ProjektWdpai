const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const confirmedPasswordInput = form.querySelector('input[name="confirmedPassword"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

emailInput.addEventListener('keyup', function () {
    setTimeout(function () {
        markValidation(emailInput, isEmail(emailInput.value));
    }, 1000);
});

confirmedPasswordInput.addEventListener('keyup', function () {
    setTimeout(function () {
        const condition = arePasswordSame(confirmedPasswordInput.previousElementSibling.value, confirmedPasswordInput.value)
        markValidation(confirmedPasswordInput, condition);
    }, 1000);
});

document.getElementById("login").addEventListener("click", function () {
    window.location.href = "http://localhost:8080/login";
});

document.getElementById("register").addEventListener("click", function () {
    window.location.href = "http://localhost:8080/register";
});
