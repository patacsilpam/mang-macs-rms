const showOrderType = () =>{
    const orderStatus = document.getElementById('order-status');
    if(orderStatus.value == "Pending"){
        document.getElementById('cancel-order').style.display = 'block';
    }
}
showOrderType()