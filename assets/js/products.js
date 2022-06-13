function changeVariation(sel) {
    let pizzaList = document.querySelectorAll('.pizzaPrice');
    let bilaoList = document.querySelectorAll('.bilaoPrice');
    //display fields of pizza price if selected
    if (sel.value == "Pizza") {
        let noneCategoryList = document.querySelectorAll('.noCategoryPrice');
        for (let i = 0; i < pizzaList.length; i++) {
            pizzaList[i].style.display = 'block';
        }
        for (let i = 0; i < noneCategoryList.length; i++) {
            noneCategoryList[i].style.display = 'none';
        }
    } else {
        let noneCategoryList = document.querySelectorAll('.noCategoryPrice');
        for (let i = 0; i < pizzaList.length; i++) {
            for (let i = 0; i < pizzaList.length; i++) {
                pizzaList[i].style.display = 'none';
            }
            for (let i = 0; i < noneCategoryList.length; i++) {
                noneCategoryList[i].style.display = 'block';
            }
        }
        //display fields of bilao price if selected
        if (sel.value == "Carbonara Bilao" || sel.value == "Palabok Bilao" || sel.value == "Pancit Bilao(Bihon Guisado)" || sel.value == "Pancit Bilao(Canton Bihon)" || sel.value == "Spaghetti Bilao") {
            let noneCategoryList = document.querySelectorAll('.noCategoryPrice');
            for (let i = 0; i < bilaoList.length; i++) {
                bilaoList[i].style.display = 'block';
            }
            for (let i = 0; i < noneCategoryList.length; i++) {
                noneCategoryList[i].style.display = 'none';
            }
        } else {
            let noneCategoryList = document.querySelectorAll('.noCategoryPrice');
            for (let i = 0; i < pizzaList.length; i++) {
                for (let i = 0; i < bilaoList.length; i++) {
                    bilaoList[i].style.display = 'none';
                }
                for (let i = 0; i < noneCategoryList.length; i++) {
                    noneCategoryList[i].style.display = 'block';
                }
            }
        }
    }
}

function clickCategory(category) {
    let categoryList = document.querySelectorAll('.categoryPrice');
    //display fields of bilao price if selected
    if (category.value == "Pizza" || category.value == "Carbonara Bilao" || category.value == "Palabok Bilao" || category.value == "Pancit Bilao(Bihon Guisado)" || category.value == "Pancit Bilao(Canton Bihon)" || category.value == "Spaghetti Bilao") {
        for (let i = 0; i < categoryList.length; i++) {
            categoryList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < categoryList.length; i++) {
            categoryList[i].style.display = 'none';
        }
    }

}

function clickStocks(stocks) {
    console.log(stocks.value);
    let sizeList = document.querySelectorAll(".sizes");
    if (stocks.value == "null") {
        for (let i = 0; i < sizeList.length; i++) {
            sizeList[i].style.display = 'none';
        }
    } else {
        for (let i = 0; i < sizeList.length; i++) {
            sizeList[i].style.display = 'block';
        }
    }
}