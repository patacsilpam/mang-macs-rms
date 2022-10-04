const countNotif = document.querySelector('#countNotif')
const dropdownToggle = document.querySelector('.dropdown-toggle')
const bellIcon = document.querySelector('.bell-icon')
console.log(countNotif.textContent);
//disable dropdown toggle in notification if it is equal to zero
if(countNotif.textContent == 0){
    dropdownToggle.classList.add('disabled');
    bellIcon.classList.remove('text-primary')
    bellIcon.classList.remove('text-secondary')
    countNotif.style.display = 'none'
}