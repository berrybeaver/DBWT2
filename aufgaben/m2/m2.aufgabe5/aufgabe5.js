'use strict';
import { data } from './data.js';
function getMaxPrice(data){
    let maxPrice = Math.max(...data.produkte.map(item => item.preis));
    let product = data.produkte.find(item => item.preis === maxPrice);
    return product;
}

const maxPriceProduct = getMaxPrice(data);
console.log('max Preis= ' + maxPriceProduct.name);

function getMinPriceProduct(data){
    let minPrice = Math.min(...data.produkte.map(item => item.preis));
    let product = data.produkte.find(item => item.preis === minPrice);
    return product;
}

const minProduct = getMinPriceProduct(data);
console.log(minProduct);

function getPriceSum(data){
    let sum = 0;
    data.produkte.forEach(item => {
        sum += item.preis;
    });
    return sum;
}

const totalPrice = getPriceSum(data);
console.log('Total price= ' + totalPrice);

function getGesamtWert(data){
    let gesamtWert = 0;
    data.produkte.forEach(item => {
        gesamtWert += (item.preis * item.anzahl);
    });
    return gesamtWert;
}

const gesamtWert = getGesamtWert(data);
console.log('Gesamtwert= ' + gesamtWert);

function getAnzahlProductOfCategory(data, categoryName){
    let AnzahlProduct = 0;
    let categoryID = 0;
    //not case sensitive search
    const categoryLower = categoryName.toLowerCase();
    data.kategorien.forEach(item => {
        if(item.name.toLowerCase() === categoryLower){
            categoryID = item.id;
        }
    });
    data.produkte.forEach(item => {
        if(item.kategorie === categoryID){
            AnzahlProduct += item.anzahl;
        }
    });
    return AnzahlProduct;
}

const category = 'garten';
const AnzahlProductofCategory = getAnzahlProductOfCategory(data, category);
console.log('Anzahl der Produkte von Category ' + category + '= '+ AnzahlProductofCategory);
