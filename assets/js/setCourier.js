const setCourier = () =>{
    const courier = document.getElementById("courier");
    const setCourier = document.getElementById("setCourier");
    console.log(courier.value);
    if(courier.value == "Pick Up"){
        setCourier.style.display = 'none' 
    }
    else{
        setCourier.style.display = 'block' 
    }
}
setCourier();