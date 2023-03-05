//    Select

const element = document.querySelector('#selectCustom');
const choices = new Choices(element, {
    searchEnabled: false,
    itemSelectText: '',
    shouldSort: false
});

// Map

ymaps.ready(init);
function init(){
// Создание карты.
    var myMap = new ymaps.Map("map", {
    // Координаты центра карты.
    // Порядок по умолчанию: «широта, долгота».
    // Чтобы не определять координаты центра карты вручную,
    // воспользуйтесь инструментом Определение координат.
        center: [48.872185073737896,2.354223999999991],
    // Уровень масштабирования. Допустимые значения:
    // от 0 (весь мир) до 19.
        zoom: 13
    });

    var myGeoObject = new ymaps.GeoObject({
        geometry: {
            type: "Point", // тип геометрии - точка
            coordinates: [48.872185073737896,2.354223999999991] // координаты точки
        }
    });

    var myPlacemark = new ymaps.Placemark([48.872185073737896,2.354223999999991], {}, {
        iconLayout: 'default#image',
        iconImageHref: 'img/map_pin.svg',
        iconImageSize: [28, 40],
        iconImageOffset: [-1, -40]
    });

    // Размещение геообъекта на карте.
    myMap.geoObjects.add(myPlacemark);
}

// InputMask

const form = document.querySelector('.form');
const telSelector = form.querySelector('input[type="tel"]');
const inputMask = new Inputmask('+375 (99) 999-99-99');
inputMask.mask(telSelector)

// Validation

new window.JustValidate('.form', {
    rules: {
        tel: {
            required: true,
            function: () => {
                const phone = telSelector.inputmask.unmaskedvalue();
                return Number(phone) && phone.length === 9;
            }
        }
    },
    colorWrong: '#FF5C00',
    messages: {
        name: {
            required: 'Вы не ввели имя',
            minLength: 'Введите 3 и более символов',
            maxLength: 'Поле должно содержать не более 15 символов'
        },
        email: {
            email: 'Введите корректный e-mail',
            required: 'Вы не ввели e-mail'
        },
        tel: {
            required: 'Вы не ввели телефон',
            function: 'Поле должно содержать 10 символов'
        }
    },

    submitHandler: function(thisForm) {
        let formData = new FormData(thisForm);

        let xhr = XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log('Отправлено');
                }
            }
        }

        xhr.open('POST', 'mail.php', true);
        xhr.send(formData);

        thisForm.reset(); //Очищение формы, после того, как мы ее отправили
    }
})