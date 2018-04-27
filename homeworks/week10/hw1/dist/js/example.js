'use strict';

var materials = ['Hydrogen', 'Helium', 'Lithium', 'Beryllium'];

console.log(materials.map(function (material) {
    return material.length;
}));
// expected output: Array [8, 6, 7, 9]

//https://developer.mozilla.org/zh-TW/docs/Web/JavaScript/Reference/Functions/Arrow_functions