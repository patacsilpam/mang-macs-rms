const addOnsContainer = document.querySelector('.add-ons-child');
const addOns = document.querySelector('#add-ons');
const removeBtn = document.querySelector('.remove-btn');

addOns.addEventListener("click",createAddOns);

function createAddOns(){
    let parentDiv = document.createElement('div');
    parentDiv.className = 'add-ons-div'

    //add on name
    let addOnsName = document.createElement('input');
    addOnsName.setAttribute('type','text')
    addOnsName.className = 'add-ons-input form-control form-control-sm'
    addOnsName.name='add-ons-name[]'
    addOnsName.placeholder='Add-on'
    addOnsName.required = true;
    parentDiv.append(addOnsName)
    //add on price
    let addOnsPrice = document.createElement('input');
    addOnsPrice.setAttribute('type','number')
    addOnsPrice.className = 'add-ons-input form-control form-control-sm'
    addOnsPrice.name='add-ons-price[]'
    addOnsPrice.placeholder = '0'
    parentDiv.append(addOnsPrice)
    //add ons quantity
    /*let addOnsQuantity = document.createElement('input');
    addOnsQuantity.setAttribute('type','number')
    addOnsQuantity.className = 'add-ons-input form-control form-control-sm'
    addOnsQuantity.name = 'add-ons-quantity[]'
    addOnsQuantity.placeholder = 0
    parentDiv.append(addOnsQuantity)*/

    //create remove button for last child element
    let createBtn = document.createElement('button');
    createBtn.textContent = "x";
    createBtn.setAttribute('type','button')
    createBtn.className = 'remove-btn'
    addOnsName.required = true;
    parentDiv.append(createBtn)
    addOnsContainer.appendChild(parentDiv)    
    
    //remove button function
    createBtn.addEventListener("click",function(e){
       e.target.parentNode.remove();
    })
}

function incrementDecBtn() {
    const minusBtn = document.getElementById('minus-btn');
    const plusBtn =  document.getElementById('plus-btn');
    let adjustQty =  0; 
    //add quantity in adjust-qty id
    plusBtn.addEventListener("click",() => {
      document.getElementById('adjust-qty').value =  ++adjustQty;
    })
    //minus quantity in adjust-qty id
    minusBtn.addEventListener("click",() => {
      document.getElementById('adjust-qty').value =  --adjustQty;
    })

}
incrementDecBtn();