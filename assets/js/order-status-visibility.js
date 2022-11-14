const showOrderType = () =>{
    const orderType = document.getElementById('order-type');
    if(orderType.value == "Pick Up"){
        document.getElementById('delivery-order').style.display = 'none'
    }
    else{
        document.getElementById('pickup-orders').style.display = 'none'
    }
    
}
showOrderType()