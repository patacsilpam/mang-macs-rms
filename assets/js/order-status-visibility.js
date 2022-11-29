const showOrderType = () =>{
    const orderType = document.getElementById('order-type');
    if(orderType.value == "Pick Up"){
        document.getElementById('out-delivery').style.display = 'none'
    }
    else{
        document.getElementById('ready-pickup').style.display = 'none'
    }
    
}
showOrderType()