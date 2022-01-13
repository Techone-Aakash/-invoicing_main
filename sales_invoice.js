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
var value = x.options[x.selectedIndex].value;
var text = x.options[x.selectedIndex].text;
document.getElementById("colThree" + [i]).value =  value;
document.getElementById("col2val" + [i]).value = text;
}
}

function numberWithCommas(x) {
var num = new Number(x);
return num.toLocaleString("en-IN");
}

function Calculate() {
let qty = 0.00;
let total = 0.00;
let grand_total = 0.00;
let Round = 0.00;
for (let i = 1; i <= count; i++) {
let num1 = document.getElementById("colFour" + i).value;
let num2 = document.getElementById("colFive" + i).value;

let num4 = parseFloat(num1 * num2).toFixed(2);
if (num1 == 0 || num2 == 0) {
document.getElementById('colSix' + i).value = "";
} else {
document.getElementById('colSix' + i).value = numberWithCommas(num4);
}
qty += parseFloat(num1);
total += parseFloat(num4);
grand_total = parseFloat(total);
Round = Math.round(grand_total) - grand_total
document.getElementById('total_amount').value = numberWithCommas(total);
document.getElementById('total_qty').value = numberWithCommas(qty);
document.getElementById('Round_Off').value = Round.toFixed(2);
document.getElementById('grand_total').value = numberWithCommas(Math.round(grand_total));
} return grand_total;
}

function main() {
Create();
Create();
}