function changeCategory(sel){
    console.log(sel.value)
    if(sel.value == "Pizza"){
        document.getElementById('pizzaBread').style.display = 'block';
        document.getElementById('pizzaVariation').style.display = 'block';
        document.getElementById('bevLiqours').style.display = 'none';
        document.getElementById('drinks').style.display = 'none';
        document.getElementById('wine').style.display = 'none';
        document.getElementById('beerBucket').style.display = 'none';
    }
    else if(sel.value == "Beverages and Liqours"){
        document.getElementById('bevLiqours').style.display = 'block';
        document.getElementById('pizzaBread').style.display = 'none';
        document.getElementById('drinks').style.display = 'none';
        document.getElementById('wine').style.display = 'none';
        document.getElementById('beerBucket').style.display = 'none';
    }
    else if(sel.value == "Drinks"){
        document.getElementById('drinks').style.display = 'block';
        document.getElementById('bevLiqours').style.display = 'none';
        document.getElementById('pizzaBread').style.display = 'none';
        document.getElementById('wine').style.display = 'none';
        document.getElementById('beerBucket').style.display = 'none';
    }
    else if(sel.value == "Wine"){
        document.getElementById('wine').style.display = 'block';
        document.getElementById('bevLiqours').style.display = 'none';
        document.getElementById('pizzaBread').style.display = 'none';
        document.getElementById('drinks').style.display = 'none';
        document.getElementById('beerBucket').style.display = 'none';
    }
    else if(sel.value == "Beer Bucket"){
        document.getElementById('beerBucket').style.display = 'block';
        document.getElementById('bevLiqours').style.display = 'none';
        document.getElementById('pizzaBread').style.display = 'none';
        document.getElementById('drinks').style.display = 'none';
        document.getElementById('wine').style.display = 'none';
    }
}