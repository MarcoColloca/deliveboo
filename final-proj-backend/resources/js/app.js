import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])


document.querySelectorAll('.item-delete-form').forEach(form => {
    form.addEventListener('submit', (ev)=>{
        ev.preventDefault();
        const modalDOMElement = form.querySelector('.my-modal');
        const modalDOMElementYes = form.querySelector('.my-modal-yes');
        const modalDOMElementNo = form.querySelector('.my-modal-no');

        modalDOMElement.classList.add('visible');

        modalDOMElementNo.addEventListener('click', function(){
            modalDOMElement.classList.remove('visible');
        })

        modalDOMElementYes.addEventListener('click', function(){
            form.submit();
        })



    })
})

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const checkboxesDOMElement = document.querySelectorAll('.checkbox');

    form.addEventListener('submit', function(ev) {

        Array.from(checkboxesDOMElement).some(checkbox => checkbox.checked);


    })
})


const loginFormDOMElement = document.querySelector('#loginForm');

loginFormDOMElement.addEventListener('submit', (ev) => {
    ev.preventDefault();

    let status = true;

    const userPasswordDOMElement = document.querySelector('#password');
    const userPasswordDOMElementValue = userPasswordDOMElement.value.trim();

    const userConfirmPasswordDomeElement = document.querySelector('#password-confirm');
    const userConfirmPasswordDomeElementValue = userConfirmPasswordDomeElement.value.trim();

    const userPasswordDOMElementRow = document.querySelector('#passwordRow');
    const userPasswordConfirmDOMElementRow = document.querySelector('#confirmPasswordRow');

    const userEmailDOMElement = document.querySelector('#email');
    const userEmailDOMElementValue = userEmailDOMElement.value.trim();

    const userEmailDOMElementRow = document.querySelector('#emailRow');



    let errorPasswordLength = userPasswordDOMElementRow.querySelector('strong.error-password-length');
    let errorPasswordNotMatch = userPasswordConfirmDOMElementRow.querySelector('strong.error-password-not-match');
    let errorEmailInvalid = userEmailDOMElementRow.querySelector('strong.error-email-invalid');

    if (!errorPasswordLength) {
        errorPasswordLength = document.createElement('strong');
        errorPasswordLength.classList.add('text-danger', 'error-password-length');
        userPasswordDOMElementRow.append(errorPasswordLength);
    }
    errorPasswordLength.innerHTML = '';

    if (!errorPasswordNotMatch) {
        errorPasswordNotMatch = document.createElement('strong');
        errorPasswordNotMatch.classList.add('text-danger', 'error-password-not-match');
        userPasswordConfirmDOMElementRow.append(errorPasswordNotMatch);
    }
    errorPasswordNotMatch.innerHTML = '';

    if (!errorEmailInvalid) {
        errorEmailInvalid = document.createElement('strong');
        errorEmailInvalid.classList.add('text-danger', 'error-email-invalid');
        userEmailDOMElementRow.append(errorEmailInvalid);
    }
    errorEmailInvalid.innerHTML = '';

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(userEmailDOMElementValue)) {

        userEmailDOMElement.classList.add('border', 'border-danger');
        errorEmailInvalid.innerHTML = 'Inserisci un indirizzo email valido.';
        status = false;
    }else{
        userEmailDOMElement.classList.remove('border', 'border-danger')
    }

    if (userPasswordDOMElementValue !== userConfirmPasswordDomeElementValue) {

        userPasswordDOMElement.classList.add('border', 'border-danger');
        userConfirmPasswordDomeElement.classList.add('border', 'border-danger');

        errorPasswordNotMatch.innerHTML = 'Le due password non corrispondono.';
        status = false;
    }else{
        userPasswordDOMElement.classList.remove('border', 'border-danger')
        userConfirmPasswordDomeElement.classList.remove('border', 'border-danger')
    }

    if (userPasswordDOMElementValue.length < 8) {
        userPasswordDOMElement.classList.add('border', 'border-danger');

        errorPasswordLength.innerHTML = 'La Password deve contenere almeno 8 caratteri';
        status = false;
    }else{
        userPasswordDOMElement.classList.remove('border', 'border-danger')
    }

    if (status === true) {
        loginFormDOMElement.submit();
    }
});
