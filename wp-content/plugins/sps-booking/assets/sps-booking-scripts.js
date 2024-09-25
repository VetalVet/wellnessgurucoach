// var ajaxurl = '/wp-admin/admin-ajax.php';
// var calendarUrl = $(".calendar").data("url");
//
// if( $(".calendar").length ){
//     $(".calendar").zabuto_calendar({
//         ajax: {
//             url: calendarUrl,
//             modal: true
//         },
//         action: function () {
//             if (zabutoCalendarParams.isLoggedIn) {
//                 var date = $("#" + this.id).data("date");
//                 $("#modal-date").val(date);
//                 return checkDate(this.id, date);
//             } else {
//                 window.location.href = '/login';
//                 return false;
//             }
//         },
//         language: "en",
//         show_previous: false,
//         today: true,
//         nav_icon: {
//             prev: '<i class="arrow_left"></i>',
//             next: '<i class="arrow_right"></i>'
//         }
//     });
// }

// $("#demo-calendar-ajax").zabuto_calendar({
//     ajax: {
//         url: scriptParams.restUrl + '?year=2024&month=5'
//     }
// });

var ajaxurl = '/wp-admin/admin-ajax.php';

if( $(".calendar").length ){https://wellnessguru.dev/wp-json/zabuto/v1/events/?year=2024&month=5&year=2024&month=5
    $(".calendar").zabuto_calendar({
        ajax: {
            url: spsBookingData.restUrl,
            modal: true,
        },
        action: function () {
            if (zabutoCalendarParams.isLoggedIn) {
                var date = $("#" + this.id).data("date");
                $("#modal-date").val(date);
                return checkDate(this.id, date);
            } else {
                window.location.href = '/login';
                return false;
            }
        },
        language: "en",
        show_previous: false,
        today: true,
        nav_icon: {
            prev: '<i class="arrow_left"></i>',
            next: '<i class="arrow_right"></i>'
        }
    });
}


$(document).ready(function() {
    // Функція для оновлення поля часу
    function updateTimeInput() {
        var selectedTime = $('#zabuto-form .btn.time-radio.active input').val(); // Отримання значення вибраної години
        $("#modal-time").val(selectedTime); // Встановлення значення прихованого поля
    }

    // Виклик функції при відкритті модального вікна для ініціалізації початкового значення
    $('#modal').on('shown.bs.modal', function () {
        updateTimeInput();
    });

    // Встановлення обробника події на клік для радіо-кнопок
    $('#zabuto-form .time-radio').on('click', function() {
        // Зміна класу активності
        $('#zabuto-form .time-radio').removeClass('active');
        $(this).addClass('active');

        // Оновлення прихованого поля з часом
        updateTimeInput();
    });
});



function checkDate(id, date) {
    $.ajax({
        url: ajaxurl, // URL до вашого серверного скрипту
        type: 'POST',
        data: {
            action: 'check_date', // Назва дії, яка має бути визначена в PHP
            date: date
        },
        success: function(response) {
            if (response.success && response.data.times) {
                updateTimes(response.data.times);
                $('#modal').modal();
            } else {
                console.log('No times available or error in response');
            }
        },
    });
}

function updateTimes(times) {
    const timeContainer = $('.btn-group').empty(); // Очистіть контейнер часів
    let selectedTimeSet = false;

    times.forEach(function(time, index) {
        const timeLabel = $('<label>').addClass('btn time-radio');
        if (!time.available) {
            timeLabel.addClass('not-available');
        } else {
            timeLabel.click(function() { // Додаємо обробник кліків, щоб оновлювати приховане поле
                $("#modal-time").val(time.hour);
            });
            if (!selectedTimeSet) { // Автоматично вибираємо перший доступний час
                timeLabel.addClass('active');
                $("#modal-time").val(time.hour);
                selectedTimeSet = true;
            }
        }
        timeLabel.html(`
            <input type="radio" name="options" value="${time.hour}" id="option_${index + 1}">${time.hour}
            <span>${time.available ? 'Available' : 'Not available'}</span>
        `);
        timeContainer.append(timeLabel);
    });
}

$('#zabuto-form').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    var $submitButton = $(this).find('button[type="submit"]'); // Знаходимо кнопку відправки
    $submitButton.prop('disabled', true); // Вимикаємо кнопку
    $submitButton.text('Sending...'); // Змінюємо текст кнопки (можна додати індикатор завантаження)

    var formData = $(this).serialize(); // Serialize all form data

    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: formData + '&action=save_appointment', // Add action parameter for WordPress
        success: function(response) {
            if(response.success) {
                if(response.data.redirect) {
                    window.location.href = response.data.redirect;
                } else {
                    alert(response.data.message);
                }
            } else {
                alert('Error: ' + response.data);
            }
        },
        error: function() {
            alert('Error sending data.');
        }
    });
});


