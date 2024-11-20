//резка прямоугольника
function calculateCuts() {

let n = parseInt(document.getElementById('length').value);
let m = parseInt(document.getElementById('width').value);

if (isNaN(n) || isNaN(m) || n <= 0 || m <= 0) {
document.getElementById('result').innerText = "Введите корректные значения для длины и ширины!";
return;
}

let cuts = 0;

while (n !== m) {
if (n > m) {
n -= m;
} else {
m -= n;
}
cuts++;
}

document.getElementById('result').innerText = `Количество отрезаний: ${cuts}`;
}

//массивы
function calculateProduct() {
const input = document.getElementById("arrayInput").value;
const arr = input.split(',').map(Number); 

if (!arr.length || arr.some(isNaN)) {
document.getElementById("result2").innerText = "Введите корректный массив чисел!";
return;
}

let lastIndex = -1;

for (let i = 0; i < arr.length; i++) {
if (Math.sin(arr[i]) < 0) {
lastIndex = i;
}
}

if (lastIndex === -1) {
document.getElementById("result2").innerText = "Среди элементов массива нет чисел с отрицательным синусом.";
return;
}

let product = 1;
for (let i = lastIndex; i < arr.length; i++) {
product *= arr[i];
}

document.getElementById("result2").innerText = `Произведение элементов: ${product}`;
}

//панграмма

function isPangram(sentence) {
const russianAlphabet = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя'; // Все буквы русского алфавита
const normalizedSentence = sentence.toLowerCase().replace(/[^а-яё]/g, ''); // Приводим к нижнему регистру и удаляем всё, кроме букв
const uniqueLetters = new Set(normalizedSentence); // Множество уникальных букв
return russianAlphabet.split('').every(letter => uniqueLetters.has(letter)); // Проверяем, содержит ли строка все буквы
}


document.getElementById('check-button').addEventListener('click', () => {
const input = document.getElementById('sentence-input').value.trim(); // Получаем введённое предложение

if (!input) {
document.getElementById('result3').textContent = 'Введите предложение.';
return;
}

const isPangramResult = isPangram(input); // Проверяем на панграмму


if (isPangramResult) {
document.getElementById('result3').textContent = 'Это панграмма.';
} else {
document.getElementById('result3').textContent = 'Это не панграмма.';
}
});
