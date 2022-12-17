const highlightOrderStatus = () =>{
    let orderStatus = document.querySelectorAll('.order-status');
    for(let i = 0; i<orderStatus.length; i++){
        if(orderStatus[i].value == "Pending"){//yellow
            orderStatus[i].style.border = '2px solid #F6D93D';
            orderStatus[i].style.backgroundColor = '#FFF4BD';
            orderStatus[i].style.color = '#E3C005';
        }
        else if(orderStatus[i].value == "Invalid Payment"  || orderStatus[i].value == "Out of Stock"){//red
            orderStatus[i].style.border = '2px solid #FA0000';
            orderStatus[i].style.backgroundColor = '#FFADAD';
            orderStatus[i].style.color = '#E00000';
        }
        else if(orderStatus[i].value == "No Shows" || orderStatus[i].value == "Cancelled"){//red
            orderStatus[i].style.border = '2px solid #FA0000';
            orderStatus[i].style.backgroundColor = '#FFADAD';
            orderStatus[i].style.color = '#E00000';
        }
        else if(orderStatus[i].value == "Not Available" ){//red
            orderStatus[i].style.border = '2px solid #FA0000';
            orderStatus[i].style.backgroundColor = '#FFADAD';
            orderStatus[i].style.color = '#E00000';
        }
        else if(orderStatus[i].value == "Order Processing" || orderStatus[i].value == "Out for Delivery" || orderStatus[i].value == "Ready for Pick Up"){
            orderStatus[i].style.border = '2px solid #6D9AF2';//blue
            orderStatus[i].style.backgroundColor = '#ABC8FF';
            orderStatus[i].style.color = '#024CDD';
        }
        else if(orderStatus[i].value == "Reserved"){
            orderStatus[i].style.border = '2px solid #6D9AF2';//blue
            orderStatus[i].style.backgroundColor = '#ABC8FF';
            orderStatus[i].style.color = '#024CDD';
        }
        else{
            orderStatus[i].style.border = '2px solid #6FAC8F';//green
            orderStatus[i].style.backgroundColor = '#9BECC5';
            orderStatus[i].style.color = '#2E7050';
        }
    }
  
}


highlightOrderStatus();

