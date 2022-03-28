const burger = document.getElementsByClassName('burger')[0]
const sidebarLinks = document.querySelectorAll('sidebar-links')
for (let i = 0; i < span.length; i++) {
    burger.addEventListener('click', () => {
        sidebarLinks[i].classList.toggle('active');
        document.querySelector('.sidebar').style.width = "100px";
    })
}