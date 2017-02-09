/**
 * Работа с формой.
 *
 * @class Form
 *
 * @param {jQuery} form - Объект формы.
 */
app.Form = function (form) {

    var FormObj = this;

    this.validation = new app.user.FormValidation(this);

    /**
     * Убирает пробелы с начала и с конца строки в элементе формы.
     *
     * @param {string[]} elements - Список названий элементов для модификации.
     */
    this.trimElements = function (elements) {
        for (var i in elements) {
            var elem = FormObj.getElementByName(elements[i]);
            if (elem.length) {
                elem.val(elem.val().trim());
            }
        }
    };

    /**
     * Очистка формы от сообщений об ошибках и т.п.
     */
    this.cleanMessages = function () {
        $("p.help-block-error", form).html('');
        $(".has-error", form).removeClass('has-error');
    };

    /**
     * Установка/снятие состояния ошибки.
     *
     * @param {string|jQuery} elem - Название или объект элемента формы.
     * @param {string} [msg=""] - Сообщение об ошибке.
     * @param {boolean} [toSet=true] - Установить или снять ошибку.
     */
    this.setError = function (elem, msg, toSet) {
        if (typeof toSet === "undefined") {
            toSet = true;
        }
        if (typeof msg === "undefined") {
            msg = "";
        }

        if (typeof elem === "string") {
            elem = FormObj.getElementByName(elem);
        }

        var group = elem.parents(".form-group");

        if (toSet) {
            group.addClass("has-error");
            $(".help-block-error", group).text(msg);
        } else {
            group.removeClass("has-error");
            $(".help-block-error", group).text("");
        }
    };

    /**
     * Устанавливает элемент как не прошедший валидацию.
     *
     * @param {jQuery} elem - Элемент не прошедший валидацию.
     * @param {string} attr - Атрибут, содержащий сообщение об ошибке.
     * @param {boolean} [attrIsMessage=false] - Является ли параметр attr текстом сообщения или названием атрибута
     * с текстом сообщения.
     */
    this.setFieldNotValid = function (elem, attr, attrIsMessage) {
        if (typeof attrIsMessage === "undefined") {
            attrIsMessage = false;
        }
        var msg = attrIsMessage ? attr : elem.attr(attr);
        FormObj.setError(elem, msg);
    };

    /**
     * Возвращает элемент формы по его имени (или по атрибуту data-name если не найден элемент по имени).
     *
     * @param {string} name - Имя элемента.
     * @returns {*|jQuery|HTMLElement}
     */
    this.getElementByName = function (name) {
        var elem = $('[name="' + name + '"]', form);
        if (!elem.length) {
            elem = $('[data-name="' + name + '"]', form);
        }
        return elem;
    };

};

