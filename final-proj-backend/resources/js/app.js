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

const checkboxesDOMElement = document.querySelectorAll('input[type="checkbox"]');
let checked = false;


const mySubmitDOMElement = document.querySelectorAll('.my-company-form')
mySubmitDOMElement.forEach(form => {

    form.addEventListener('submit', (ev) => {
        ev.preventDefault();
        checked = false;
        checkboxesDOMElement.forEach(checkbox =>{
          if(checkbox.checked) {
              checked = true;
        } 
    }); 
        if(checked) {
            document.getElementById('error-text').textContent='';
            form.submit();
        }else{

            document.getElementById('error-text').textContent='perfavore seleziona una tipologia';
        }
   
        });
    
    });

