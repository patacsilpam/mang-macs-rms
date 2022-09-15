const addOnsContainer = document.querySelector('.add-ons-child');
const addOns = document.querySelector('#add-ons');
const removeBtn = document.querySelector('.remove-btn');

addOns.addEventListener("click",createAddOns);

function createAddOns(){
    console.log(1);
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