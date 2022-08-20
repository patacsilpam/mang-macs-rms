const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
togglePassword.addEventListener('click', function(e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('fa-eye-slash');
});
//hide password input
function clickPos(position){
    let hidePassword = document.querySelectorAll('.hide-password');
    let i;
    if(position.value == "Admin"){
       for(i = 0 ; i<hidePassword.length; i++){
            hidePassword[i].style.display = "none";
       }
    }
    else{
        for(i = 0 ; i<hidePassword.length; i++){
            hidePassword[i].style.display = "block";
        }
    }
}