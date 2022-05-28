let variationContainerList = document.querySelectorAll('.variationContainer');
for (let i = 0; i < variationContainerList.length; i++) {
    variationContainerList[i].style.display = 'none';
}

function changeVariation(sel) {
    const productCategory = document.querySelector('.prodCategory').value;
    let pizzaList = document.querySelectorAll('.pizza');
    let mealsGoodList = document.querySelectorAll('.mealsGood');
    let palabokBilaoList = document.querySelectorAll('.palabokBilao');
    let pancitBihonList = document.querySelectorAll('.pancitBihon');
    let pancitCantonList = document.querySelectorAll('.pancitCanton');
    let spaghettiBilaoList = document.querySelectorAll('.spaghettiBilao');
    let containerList = document.querySelectorAll('.variationContainer');
    let editVariationList = document.querySelectorAll('.editVariation');
    for (let i = 0; i < mealsGoodList.length; i++) {
        mealsGoodList[i].style.display = 'none';
    }

    for (let i = 0; i < pizzaList.length; i++) {
        pizzaList[i].style.display = 'none';
    }
    for (let i = 0; i < palabokBilaoList.length; i++) {
        palabokBilaoList[i].style.display = 'none';
    }
    for (let i = 0; i < pancitBihonList.length; i++) {
        pancitBihonList[i].style.display = 'none';
    }

    for (let i = 0; i < pancitCantonList.length; i++) {
        pancitCantonList[i].style.display = 'none';
    }

    for (let i = 0; i < spaghettiBilaoList.length; i++) {
        spaghettiBilaoList[i].style.display = 'none';
    }
    //compare the value Meals Goodfor  3pax
    if (productCategory == "Meals Good for 3 pax" || sel.value == "Meals Good for 3 pax") {
        for (let i = 0; i < mealsGoodList.length; i++) {
            mealsGoodList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < mealsGoodList.length; i++) {
            mealsGoodList[i].style.display = 'none';
        }
    }
    //compare the value Pizza
    if (productCategory == "Pizza" || sel.value == "Pizza") {
        for (let i = 0; i < pizzaList.length; i++) {
            pizzaList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < pizzaList.length; i++) {
            pizzaList[i].style.display = 'none';
        }
    }
    //compare the value Palabok Bilao
    if (productCategory == "Palabok Bilao" || sel.value == "Palabok Bilao") {
        for (let i = 0; i < palabokBilaoList.length; i++) {
            palabokBilaoList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < palabokBilaoList.length; i++) {
            palabokBilaoList[i].style.display = 'none';
        }
    }
    //compare the value Pancit Bilao(Bihon)
    if (productCategory == "Pancit Bilao(Bihon)" || sel.value == "Pancit Bilao(Bihon)") {
        for (let i = 0; i < pancitBihonList.length; i++) {
            pancitBihonList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < pancitBihonList.length; i++) {
            pancitBihonList[i].style.display = 'none';
        }
    }
    //compare the value Pancit Bilao(Canton)
    if (productCategory == "Pancit Bilao(Canton)" || sel.value == "Pancit Bilao(Canton)") {
        for (let i = 0; i < pancitCantonList.length; i++) {
            pancitCantonList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < pancitCantonList.length; i++) {
            pancitCantonList[i].style.display = 'none';
        }
    }
    //compare the value Spaghetti Bilao
    if (productCategory == "Spaghetti Bilao" || sel.value == "Spaghetti Bilao") {
        for (let i = 0; i < spaghettiBilaoList.length; i++) {
            spaghettiBilaoList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < spaghettiBilaoList.length; i++) {
            spaghettiBilaoList[i].style.display = 'none';
        }
    }
    if (productCategory == "Meals Good for 3 pax" || sel.value == "Meals Good for 3 pax" || productCategory == "Pizza" || sel.value == "Pizza" || productCategory == "Palabok Bilao" || sel.value == "Palabok Bilao" || productCategory == "Pancit Bilao(Bihon)" || sel.value == "Pancit Bilao(Bihon)" || productCategory == "Pancit Bilao(Canton)" || sel.value == "Pancit Bilao(Canton)" || productCategory == "Spaghetti Bilao" || sel.value == "Spaghetti Bilao") {
        for (let i = 0; i < containerList.length; i++) {
            variationContainerList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < variationContainerList.length; i++) {
            variationContainerList[i].style.display = 'none';
        }
        for (let i = 0; i < editVariationList.length; i++) {
            editVariationList[i].value = "";
        }
    }
}

function clickPrice(category) {
    console.log(category.value)
        //meals good
    let mealsGoodsList = document.querySelectorAll('.mealsGoods');
    let pizzaList = document.querySelectorAll('.pizzas');
    let palabokBilaoList = document.querySelectorAll('.palabokBilaos');
    let pancitBihonList = document.querySelectorAll('.pancitBihons');
    let pancitCantonList = document.querySelectorAll('.pancitCantons');
    let spaghettiBilaoList = document.querySelectorAll('.spaghettiBilaos');
    let editVariationContainerList = document.querySelectorAll('.editVariationContainer');
    if (category.value == "Meals Good for 3 pax") {
        for (let i = 0; i < mealsGoodsList.length; i++) {
            mealsGoodsList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < mealsGoodsList.length; i++) {
            mealsGoodsList[i].style.display = 'none';
        }
    }
    //pizza
    if (category.value == "Pizza") {
        for (let i = 0; i < pizzaList.length; i++) {
            pizzaList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < pizzaList.length; i++) {
            pizzaList[i].style.display = 'none';
        }
    }
    //palabok bilao
    if (category.value == "Palabok Bilao") {
        for (let i = 0; i < palabokBilaoList.length; i++) {
            palabokBilaoList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < palabokBilaoList.length; i++) {
            palabokBilaoList[i].style.display = 'none';
        }
    }
    //pancit Bihon
    if (category.value == "Pancit Bilao(Bihon)") {
        for (let i = 0; i < pancitBihonList.length; i++) {
            pancitBihonList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < pancitBihonList.length; i++) {
            pancitBihonList[i].style.display = 'none';
        }

    }
    //Pancit Canton
    if (category.value == "Pancit Bilao(Canton)") {
        for (let i = 0; i < pancitCantonList.length; i++) {
            pancitCantonList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < pancitCantonList.length; i++) {
            pancitCantonList[i].style.display = 'none';
        }

    }
    //Spaghetti Bilao
    if (category.value == "Spaghetti Bilao") {
        for (let i = 0; i < spaghettiBilaoList.length; i++) {
            spaghettiBilaoList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < spaghettiBilaoList.length; i++) {
            spaghettiBilaoList[i].style.display = 'none';
        }

    }
    if (category.value == "Meals Good for 3 pax" || category.value == "Pizza" || category.value == "Palabok Bilao" || category.value == "Pancit Bilao(Bihon)" || category.value == "Pancit Bilao(Canton)" || category.value == "Spaghetti Bilao") {
        for (let i = 0; i < editVariationContainerList.length; i++) {
            editVariationContainerList[i].style.display = 'block';
        }
    } else {
        for (let i = 0; i < editVariationContainerList.length; i++) {
            editVariationContainerList[i].style.display = 'none';
        }
    }
}