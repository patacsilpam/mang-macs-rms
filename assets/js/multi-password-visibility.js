function toggle(e) {
    const password = document.getElementsByClassName('togglePassword');
    for (let item of password) {
        item.type = e.checked ? 'text' : 'password';
    }
}