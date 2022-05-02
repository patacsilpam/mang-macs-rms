const navBar = () => {
    const navMenu = document.getElementById('menu');
    const navLists = document.querySelectorAll('span');
    navMenu.addEventListener("click", () => {
        for (let i = 0; i < navLists.length; i++) {
            navLists[i].classList.toggle('active');
        }

    })
}

navBar();