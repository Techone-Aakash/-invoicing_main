function Delete() {
var table = document.getElementById("mytable");
count = --count;// count - 1
if (count == 0) { count++; }
else {
count;
table.deleteRow(-1);
}
return count - 1;
}

function selectoption() {

for (i = 1; i < i + 1; i++) {
let x = document.getElementById("colTwo" + [i]);
x2 = x.value;
console.log(x2);
const myArr = x2.split("|");

if(myArr[1] == undefined){
  document.getElementById("colSixGst" + [i]).textContent = document.getElementById("colSevenGst" + [i]).textContent = 0; 
}else{
  document.getElementById("colThree" + [i]).value =  myArr[0];
  document.getElementById("col6val" + [i]).value = myArr[1];
  document.getElementById("colSixGst" + [i]).textContent = document.getElementById("colSevenGst" + [i]).textContent = myArr[1]+"%";
}

var value = x.options[x.selectedIndex].value;
var text = x.options[x.selectedIndex].text;
document.getElementById("col2val" + [i]).value = text;
Calculate();
}
}

function numberWithCommas(x) {
var num = new Number(x);
return num.toLocaleString("en-IN");
}

function Calculate() {
let qty = 0.00;
let sgst_cgst = 0.00;
let total = 0.00;
let grand_total = 0.00;
let Round = 0.00;
for (let i = 1; i <= count; i++) {
let num1 = document.getElementById("colFour" + i).value;
let num2 = document.getElementById("colFive" + i).value;
let gstval = document.getElementById("col6val" + i).value;

let num4 = parseFloat(num1 * num2).toFixed(2);
let num3 = parseFloat((num4 * gstval) / 100).toFixed(2);
if (num1 == 0 || num2 == 0) {
document.getElementById('colSix' + i).value = "";
document.getElementById('colSeven' + i).value = "";
document.getElementById('colEight' + i).value = "";
} else {
document.getElementById('colSix' + i).value = numberWithCommas(num3);
document.getElementById('colSeven' + i).value = numberWithCommas(num3);
document.getElementById('colEight' + i).value = numberWithCommas(num4);
}
qty += parseFloat(num1);
sgst_cgst += parseFloat(num3);
total += parseFloat(num4);
grand_total = parseFloat(sgst_cgst) + parseFloat(sgst_cgst) + parseFloat(total);
Round = Math.round(grand_total) - grand_total
document.getElementById('total_amount').value = numberWithCommas(total);
document.getElementById('total_qty').value = numberWithCommas(qty);
document.getElementById('total_sgst').value = numberWithCommas(sgst_cgst);
document.getElementById('total_cgst').value = numberWithCommas(sgst_cgst);
document.getElementById('Round_Off').value = Round.toFixed(2);
document.getElementById('grand_total').value = numberWithCommas(Math.round(grand_total));
} return grand_total;
}

function main() {
Create();
Create();
}