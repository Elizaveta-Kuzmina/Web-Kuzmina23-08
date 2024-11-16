document.querySelector('form').addEventListener('submit', function (event) {
event.preventDefault(); 

let errors = {};
 
let name = document.getElementById('name').value.trim();
let phone = document.getElementById('phone').value.trim();
let email = document.getElementById('email').value.trim();
let model = document.getElementById('model').value;
let issue = document.getElementById('issue').value.trim();
let time = document.getElementById('time').value.trim();
let agreement = document.querySelector('input[name="agreement"]').checked;


if (!name) {
errors.name = 'Это поле обязательно для заполнения.';
}

if (!phone || !/^\+7\s?\(?\d{3}\)?\s?\d{3}-?\d{2}-?\d{2}$/.test(phone)) {
errors.phone = 'Введите корректный номер телефона в формате +7 (999) 999-99-99.';
}
else if (!phone) {
errors.phone = 'Это поле обязательно для заполнения.';
}

if (!email || !/^[\w.-]+@[a-zA-Z_-]+\.[a-zA-Z]{2,}$/.test(email)) {
errors.email = 'Введите корректный email.';
}


if (!model) {
errors.model = 'Выберите модель ноутбука.';
}

if (!agreement) {
errors.agreement = 'Вы должны согласиться с условиями.';
}

document.querySelectorAll('.error-message').forEach((el) => el.remove());


if (Object.keys(errors).length > 0) {
for (const [key, message] of Object.entries(errors)) {
const field = document.getElementById(key);
const errorElement = document.createElement('div');
errorElement.className = 'error-message';
errorElement.textContent = message;
field.parentNode.appendChild(errorElement);
}
return;
}


let output = document.createElement('div');
output.innerHTML = `
<h3>Заявка успешно отправлена!</h3>
<p><strong>Имя:</strong> ${name}</p>
<p><strong>Телефон:</strong> ${phone}</p>
<p><strong>Email:</strong> ${email || 'Не указан'}</p>
<p><strong>Модель ноутбука:</strong> ${model}</p>
<p><strong>Описание проблемы:</strong> ${issue || 'Не указано'}</p>
<p><strong>Удобное время для звонка:</strong> ${time || 'Не указано'}</p>
`;
document.body.appendChild(output);


event.target.reset();
});
