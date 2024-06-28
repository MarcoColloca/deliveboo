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