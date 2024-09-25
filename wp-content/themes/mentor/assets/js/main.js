// Callendar
// Запуск скрипту після завантаження сторінки


if (window.location.hash && window.location.hash === '#_=_') {
  if (window.history && history.pushState) {
    window.history.pushState("", document.title, window.location.pathname);
  } else {
    // Падіння назад для браузерів, що не підтримують HTML5 історію
    window.location.hash = '';
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Валідація номера
  function restrictInput(event) {
    const inputField = event.target;
    // Видаляємо всі символи, які не є цифрами або символами
    inputField.value = inputField.value.replace(/^[a-zA-Zа-яА-Я]+$/g, "");
  }

  // // Додаємо обробник події для події "input" (зміна значення поля вводу)
  // document
  //   .getElementById("inputPhone")
  //   .addEventListener("input", restrictInput);

  // Dropdown

  const dropdowns = document.querySelectorAll(".dropdown");

  dropdowns.forEach((dropdown) => {
    const buttonDropdown = dropdown.querySelector(
        ".interviewer-dropdown__button"
    );
    const listDropdown = dropdown.querySelector(".interviewer-dropdown__list");

    buttonDropdown.addEventListener("click", function (e) {
      listDropdown.classList.add("active");
    });

    listDropdown.addEventListener("click", function (e) {
      const target = e.target;
      const inputDropbdown = dropdown.querySelector("input");
      buttonDropdown.innerText = target.innerText;
      inputDropbdown.value = target.innerText;
      listDropdown.classList.remove("active");
    });
  });
  // Опитувач

  const interviewerSections = document.querySelectorAll(
      ".interviewer__section"
  );
  const interviewerForm = document.querySelector(".interviewer__form");

  const navigateSections = (currentIndex, nextIndex) => {
    interviewerSections[currentIndex].classList.remove("active");
    interviewerSections[nextIndex].classList.add("active");
    const sectionIdAttrPrev =
        interviewerSections[currentIndex].getAttribute("id");
    const sectionIdAttrNext = interviewerSections[nextIndex].getAttribute("id");
    const navigationIconNext = document.querySelector(`.${sectionIdAttrNext}`);
    const navigationIconPrev = document.querySelector(`.${sectionIdAttrPrev}`);
    navigationIconNext.classList.add("active");
    navigationIconPrev.classList.remove("active");
  };

  const validateInputs = (inputs) => {
    let isValid = true;
    inputs.forEach((input) => {
      const parent = input.closest('.dropdown');
      if (input.value.trim().length === 0) {
        if (parent) {
          parent.classList.add("error");
        }
        input.classList.add("error");
        isValid = false;
      } else {
        if (parent) {
          parent.classList.remove("error");
        }
        input.classList.remove("error");
      }
    });
    return isValid;
  };

  const validateAge = (dateInput) => {
    const birthDate = new Date(dateInput.value);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }

    return age >= 18;
  };

  document.querySelectorAll('.interviewer__section').forEach((section, i) => {
    const buttonNext = section.querySelector(".interviewer__button-next-section");
    const buttonBack = section.querySelector(".interviewer__button-back-section");
    const buttonSubmit = section.querySelector(".interviewer__button-submit-section");

    if (buttonNext) {
      buttonNext.addEventListener("click", function (e) {
        e.preventDefault();
        const inputs = section.querySelectorAll("input, textarea");
        const dateInput = section.querySelector("input[name='date_birth']");

        if (validateInputs(inputs)) {
          if (dateInput && !validateAge(dateInput)) {
            const errorMessage = document.getElementById("age-error-message");
            if (!errorMessage) {
              const errorElement = document.createElement("div");
              errorElement.id = "age-error-message";
              errorElement.style.color = "red";
              errorElement.style.marginTop = "10px";
              errorElement.textContent = "You should be at least 18 years old to proceed";
              dateInput.parentNode.appendChild(errorElement);
            }
          } else {
            const errorMessage = document.getElementById("age-error-message");
            if (errorMessage) {
              errorMessage.remove();
            }
            navigateSections(i, i + 1);
          }
        }
      });
    }

    if (buttonBack) {
      buttonBack.addEventListener("click", function (e) {
        e.preventDefault();
        navigateSections(i, i - 1);
      });
    }

    if (buttonSubmit) {
      buttonSubmit.addEventListener("click", function (e) {
        e.preventDefault();
        const inputs = section.querySelectorAll("input, textarea");
        if (validateInputs(inputs)) {
          document.getElementById("interviewer__form").submit();
        }
      });
    }
  });

  //Відправка форми
//   if (interviewerForm) {
//     interviewerForm.addEventListener("submit", function (e) {
//       e.preventDefault();
//       const textareaList = interviewerSections[2].querySelectorAll("textarea");
//       if (validateInputs(textareaList)) {
//         const formData = new FormData(interviewerForm);
//         const formDataAsObject = Object.fromEntries(formData);
//
//         const xhr = new XMLHttpRequest();
//         xhr.open("POST", urlSendMailForm.sendMail, true);
// //         xhr.open("POST", "https://wellnessgurucoach.com/mail/", true);
//         xhr.send(JSON.stringify(formDataAsObject));
//
//         xhr.onreadystatechange = function () {
//           if (xhr.readyState === 4 && xhr.status === 200) {
//             // Выводим ответ сервера в консоль
//             console.log(xhr.responseText);
//             window.location = `${window.location.origin}/login`;
//             console.log(`${window.location.origin}/login`);
//           }
//         };
//         console.log("Form submitted successfully!");
//       }
//     });
//   }

  // Мобільне меню

  const sidebar = document.querySelector(".sidebar__list");

  if (sidebar) {
    sidebar.addEventListener("click", (event) => {
      const clickedItem = event.target.closest(".sidebar__item");

      if (clickedItem) {
        const itemList = document.querySelectorAll(".sidebar__item");
        console.log(itemList);
        itemList.forEach((item) => {
          item.classList.remove("active");
          const itemContent = item.children[1];
          if (itemContent) {
            itemContent.classList.remove("active");
          }
        });

        clickedItem.classList.add("active");
        const itemContent = clickedItem.children[1];
        if (itemContent) {
          itemContent.classList.add("active");
        }
      }
    });
  }

  // Підказки для пакетів

  const availablesBox = document.querySelectorAll(".available-box");
  availablesBox.forEach((availableBox) => {
    const svgInfo = availableBox.querySelector("svg");
    const serviceDescription = availableBox.querySelector(
        ".service-description"
    );

    const serviceDescriptionSvg = availableBox.querySelector(
        ".service-description svg"
    );

    svgInfo.addEventListener("mouseover", function (e) {
      serviceDescription.classList.add("active");
      serviceDescriptionSvg.classList.add("active");
    });

    svgInfo.addEventListener("mouseout", function (e) {
      serviceDescription.classList.remove("active");
      serviceDescriptionSvg.classList.remove("active");
    });
  });

  //

  // Модальне вікно
  const modal = document.querySelector(".modal-appointments");
  if (modal) {
    const modalWindow = modal.querySelector(".modal-appointments__window");
    const closeButton = modal.querySelector(".modal-appointments__close");
    const infoButton = document.querySelector(".appointments__item-data svg");
    const body = document.querySelector("body");
    if (infoButton) {
      infoButton.addEventListener("click", () => {
        modal.classList.add("active");
        body.style.overflowY = "hidden";
      });
    }

    modal.addEventListener("click", function (e) {
      if (modal.classList.contains("active") && e.target === this) {
        modal.classList.remove("active");
        body.style.overflowY = "visible";
      }
    });

    closeButton.addEventListener("click", () => {
      if (modal.classList.contains("active")) {
        modal.classList.remove("active");
        body.style.overflowY = "visible";
      }
    });
  }

  // Перемикач office

  const sidebarOfiiceLink = ["manage-profile", "appointments", "my-program"];
  const sidebarOfficeList = document.querySelectorAll(".sidebar__item");

  const officeContent = document.querySelector(".office__content");

  sidebarOfficeList.forEach((item) => {
    item.addEventListener("click", function (e) {
      sidebarOfficeList.forEach((item) => {
        item.classList.remove("active");
      });

      item.classList.add("active");
      const itemLink = item
          .querySelector("a")
          .getAttribute("href")
          .replace(/^#/, "");

      for (let contentElement in officeContent.children) {
        if (officeContent.children[contentElement] instanceof HTMLElement) {
          const officeContentElement = officeContent.children[contentElement];
          const officeClassElement = officeContentElement
              .getAttribute("class")
              .replace(/office__/, "");

          if (itemLink === officeClassElement) {
            for (let contentElement in officeContent.children) {
              if (
                  officeContent.children[contentElement] instanceof HTMLElement
              ) {
                officeContent.children[contentElement].classList.remove(
                    "active"
                );
              }
              officeContentElement.classList.add("active");
            }
          }
        }
      }
    });
  });

});

jQuery(document).ready(function($) {
  $('.show-booking-info').on('click', function() {
    var modalId = $(this).attr('id').replace('bookinginfo', 'bookinginfo_modal');
    $('#' + modalId).addClass('active');
  });

  $('.modal-appointments__close').on('click', function() {
    $(this).closest('.modal-appointments-info').removeClass('active');
  });
});
