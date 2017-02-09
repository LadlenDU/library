"use strict";

/**
 * Отвечает за логику валидации (модель, использующая вид как хранилище данных).
 *
 * @class FormValidation
 *
 * @param {object} form - Объект для работы с формой.
 * @param {function(string):(*|jQuery|HTMLElement)} form.getElementByName - Возвращает элемент формы по его имени.
 * @param {function(jQuery)} form.setFieldNotValid - Устанавливает элемент как не прошедший валидацию.
 */
//TODO: правильные аргументы описать
app.user.FormValidation = function (form) {

    /**
     * Проверяет наличие значения в поле, если значения нет - устанавливает поле как ошибочное.
     *
     * @param {jQuery} elem - Объект тестируемого элемента.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.notEmpty = function (elem) {
        if (!elem.val()) {
            form.setFieldNotValid(elem, "data-v-notEmpty-text");
            return false;
        }
        return true;
    };

    /**
     * Проверка поля на минимальную длину содержимого.
     *
     * @param {jQuery} elem - Объект тестируемого элемента.
     * @param {int} minLength - Минимальная длина строки.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.lengthNotLess = function (elem, minLength) {
        //var minLength = elem.attr("data-v-lengthNotLess");
        if (elem.val().length < minLength) {
            form.setFieldNotValid(elem, "data-v-lengthNotLess-text");
            return false;
        }
        return true;
    };

    /**
     * Проверяет нет ли в БД совпадающего значения элемента.
     *
     * @param {jQuery} elem - Объект тестируемого элемента.
     * @param {string[]} params - Тестируемые параметры.
     * @param {string} params.table - Название таблицы.
     * @param {string} params.column - Название колонки.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.notInDbList = function (elem, params) {
        var value = elem.val();
        var name = elem.attr("name");
        var async_name = name + "_async_verify";
        var data = {action: "notInDbList", ajax: 1, table: params.table, column: params.column, field: name};
        data[name] = value;
        if (value) {
            form.form.trigger("async_action_start", async_name);
            $.ajax({
                url: "/user/info",
                data: data,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.state == "error") {
                        form.setFieldNotValid(elem, data.data, true);
                    }
                }
            }).always(function () {
                form.form.trigger("async_action_end", async_name);
            });
        }

        return true;
    };

    /**
     * Проверка на соответствие полей.
     *
     * @param {jQuery} elem - Объект первого поля.
     * @param {string} checkedElemName - Название второго поля.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.equalStrings = function (elem, checkedElemName) {
        var checkedElem = form.getElementByName(checkedElemName);
        if (elem.val() != checkedElem.val()) {
            form.setFieldNotValid(elem, "data-v-equalStrings-text");
            return false;
        }
        return true;
    };

    /**
     * Проверка на корректность email.
     *
     * @param {jQuery} elem - Объект тестируемого элемента.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.email = function (elem) {
        var expr = /^$|^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        //var expr = /^-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/;
        if (!expr.test(elem.val())) {
            form.setFieldNotValid(elem, "data-v-email-text");
            return false;
        }
        return true;
    };

    /**
     * Валидация телефона.
     *
     * @param {jQuery} elem - Объект тестируемого элемента.
     * @returns {boolean} [=true] - Пройдена ли валидация (всегда true, т. к. валидация происходит асинхронно).
     */
    this.phone = function (elem) {
        var phone = elem.val();
        if (phone) {
            form.form.trigger("async_action_start", "phone_async_verify");
            $.ajax({
                url: "https://lookups.twilio.com/v1/PhoneNumbers/" + encodeURIComponent(phone),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa("AC7a67691fdf0d12f90f89b84ad9bc33a1:87d68ed8656de6a1072aa7a25767b396"));
                    //xhr.setRequestHeader("Authorization", "Basic " + btoa("AC7a67691fdff0d12f90f89b84ad9bc33a1:87d68ed8656de6a1072aa7a25767b396sdsd"));
                },
                type: "GET",
                dataType: "json",
                contentType: "application/json",
                processData: false,
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 404) {
                        form.setFieldNotValid(elem, "data-v-phone-text");
                    }
                    else {
                        var msg = elem.attr("data-v-phone-request-text").sprintf(jqXHR.status);
                        // Предупреждаем об ошибке, но ошибку не устанавливаем,
                        // т. к. не факт что это ошибка пользователя.
                        alert(msg);
                    }
                }
            }).always(function () {
                form.form.trigger("async_action_end", "phone_async_verify");
            });
        }

        return true;
    };

    /**
     * Валидация даты.
     *
     * @param {jQuery} elem - Объект с информацией о тестируемом элементе.
     * @param {int[]} dt - Значения даты.
     * @param {int} dt.day - День.
     * @param {int} dt.month - Месяц.
     * @param {int} dt.year - Год.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.date = function (elem, dt) {
        var res = false;

        var day = form.getElementByName(dt.day).val(),
            month = form.getElementByName(dt.month).val(),
            year = form.getElementByName(dt.year).val();

        if (day < 0 && month < 0 && year < 0) {
            res = true;
        } else {
            var d = new Date(year, month, day);

            if (d.getFullYear() != year
                || d.getMonth() != month
                || d.getDate() != day) {

                form.setFieldNotValid(elem, "data-v-date-text");
            } else {
                res = true;
            }
        }

        return res;
    };

    /**
     * Валидация размера изображения.
     *
     * @param {jQuery} elem - Объект тестируемого элемента.
     * @param {Object} params - Список параметров.
     * @param {File} params.file - Изображение.
     * @param {int} params.maxSize - Максимальный размер изображения.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.imageMaxSize = function (elem, params) {
        var file = params['file'];
        var maxSize = params['maxSize'];
        if (file && file.size > maxSize) {
            form.setFieldNotValid(
                elem,
                $(elem)
                    .attr("data-v-imageSizeNotLessThan-text") + " " + $(elem).attr("data-v-imageSizeIs-text")
                    .sprintf(file.size),
                true
            );
            return false;
        }
        return true;
    };

    /**
     * Валидация изображения по типу. Если поддерживается, то тестируется содержимое файла, если нет - то расширение.
     *
     * @param {jQuery} elem - Объект тестируемого элемента.
     * @param {object} params - Список параметров.
     * @param {File} params.file - Изображение.
     * @param {Array} params.ext - Список поддерживаемых расширений файла.
     * @param {Array} params.MIME - Список поддерживаемых MIME типов файла.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.imageMIME = function (elem, params) {
        if (params.file) {
            if (window.FileReader && window.Blob) {

                form.form.trigger("async_action_start", "imageType_async_verify");

                var fReader = new FileReader();
                fReader.onloadend = function (e) {
                    var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
                    var header = "";
                    for (var i = 0; i < arr.length; i++) {
                        header += arr[i].toString(16);
                    }

                    var type = "unknown";
                    switch (header) {
                        case "89504e47":
                            type = "image/png";
                            break;
                        case "47494638":
                            type = "image/gif";
                            break;
                        case "ffd8ffe0":
                        case "ffd8ffe1":
                        case "ffd8ffe2":
                            type = "image/jpeg";
                            break;
                        default:
                            type = "unknown"; // Or you can use the blob.type as fallback
                            break;
                    }

                    if (params.MIME.indexOf(type) == -1) {
                        form.setFieldNotValid(elem, "data-v-unknownImageMime-text");
                    }

                    form.form.trigger("async_action_end", "imageType_async_verify");
                };
                fReader.readAsArrayBuffer(params.file);
            } else {
                // Тестирование по расширению, если невозможно тестирование по первым байтам.
                //var exts = $(elem).attr("data-v-acceptedImageExtensions");
                var exts = app.helper.implode("|", params.ext);
                var reg = new RegExp("\.(" + exts + ")$", 'i');
                if (!reg.test(params.file.name)) {
                    form.setFieldNotValid(
                        elem, $(elem).attr("data-v-unsupportedImageExtension-text").sprintf(params.file.name), true
                    );
                    return false;
                }
            }
        }
        return true;
    };

    /**
     * Вызов проверяющих функций.
     *
     * @param {string} field - Название поля.
     * @param {object[]} funcList - Список функций в виде названий ключей и аргументов функций в виде параметров.
     * @returns {boolean} - Пройдена ли валидация.
     */
    this.validateByFunction = function (field, funcList) {
        var resElem = true;
        for (var funcName in funcList) {
            var elem = form.getElementByName(field);
            if (this[funcName]) {
                if (!(resElem = this[funcName](elem, funcList[funcName]))) {
                    break;
                }
            } else {
                app.helper.log('No validation function: ' + funcName);
            }
        }
        return resElem;
    };

};
