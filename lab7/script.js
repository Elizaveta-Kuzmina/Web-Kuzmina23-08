let currentInput = '';
let currentOperator = null;
let previousValue = null;

function inputNumber(num) {
if (num === '.' && currentInput.includes('.')) {
return;
}
currentInput += num;
updateDisplay();
}

function operate(operator) {
if (currentInput === '' && previousValue === null) return;
if (previousValue === null) {
previousValue = parseFloat(currentInput);
} else if (currentOperator) {
calculate();
}
currentOperator = operator;
currentInput = '';
}

function calculate() {
if (!currentOperator || currentInput === '') return;
const currentValue = parseFloat(currentInput);
switch (currentOperator) {
case '+':
previousValue += currentValue;
break;
case '-':
previousValue -= currentValue;
break;
case '*':
previousValue *= currentValue;
break;
case '/':
if (currentValue === 0) {
alert('Деление на ноль невозможно');
return;
}
previousValue /= currentValue;
break;
case '%':
previousValue = (previousValue * currentValue) / 100;
break;
}
currentInput = previousValue.toString();
currentOperator = null;
updateDisplay();
}

function clearAll() {
currentInput = '';
previousValue = null;
currentOperator = null;
updateDisplay();
}

function clearEntry() {
currentInput = '';
updateDisplay();
}

function backspace() {
currentInput = currentInput.slice(0, -1);
updateDisplay();
}

function changeSign() {
if (currentInput !== '') {
currentInput = (parseFloat(currentInput) * -1).toString();
updateDisplay();
}
}

function oneOver() {
if (currentInput === '') return;
const value = parseFloat(currentInput);
if (value === 0) {
alert('Деление на ноль невозможно');
return;
}
currentInput = (1 / value).toString();
updateDisplay();
}

function squareRoot() {
if (currentInput === '') return;
const value = parseFloat(currentInput);
if (value < 0) {
alert('Квадратный корень отрицательного числа невозможен');
return;
}
currentInput = Math.sqrt(value).toString();
updateDisplay();
}

function updateDisplay() {
const display = document.getElementById('display');
display.value = currentInput || '0';
}
