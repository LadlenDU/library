"use strict";
//TODO: удалить везде логирование в конце
/**
 * Форма пользователя.
 *
 * @class EditForm
 *
 * @param {jQuery} form - Объект формы.
 */
app.user.EditForm = function (form) {

    var EditFormObj = this;

    // Вызов родительского конструктора.
    app.user.EditForm.superclass.constructor.call(this, form);

    this.form = form;

    /**
     * Операции с блоком изображения.
     *
     * @namespace
     */
    var image = {
        /**
         * Предварительный просмотр изображения.
         *
         * @param {File} file
         */
        showImage: function (file) {
            if (!window.FileReader) {
                return;
            }

            window.URL = window.URL || window.webkitURL;

            var reader = new FileReader();
            reader.addEventListener("load", function (e) {
                var useBlob = window.Blob && window.URL;

                var image = new Image();

                image.src = useBlob ? window.URL.createObjectURL(file) : reader.result;

                image.addEventListener("load", function () {
                    $(".image_container a", form).attr("href", image.src);
                    $(".image_container a img", form).attr("src", image.src);
                });

                if (useBlob) {
                    window.URL.revokeObjectURL(file); // Освобождаем память.
                }
            });

            reader.readAsDataURL(file);
        },

        /**
         * Сохранение оригинального состояния загрузки изображения.
         *
         * @static
         */
        saveState: function () {
            if (!this.showImage.imageNew) {
                this.showImage.imageNew = $(".image_input_container", form).clone(true, true);
            }
        },

        /**
         * Восстановление оригинального состояния загрузки изображения
         * или установка изображения по умолчанию (пустое) если предыдущий статус не сохранен.
         *
         * @static
         */
        backState: function () {
            if (this.showImage.imageNew) {
                $(".image_input_container", form).replaceWith(this.showImage.imageNew);
                delete this.showImage.imageNew;
            } else {
                // Пустое изображение.
                var ni = EditFormObj.noImage;
                $(".image_container a", form).attr("href", ni.original.src);
                $(".image_container a img", form).attr({
                    src: ni.thumbnail.src,
                    width: ni.thumbnail.width,
                    height: ni.thumbnail.height
                });
                $("input[name='stored_image\[original\]'], input[name='stored_image\[thumbnail\]']", form).val("");

                //this.clearUpload();
            }
            this.clearUpload();
        },

        /**
         * Очистка состояния загрузки.
         *
         * @static
         */
        clearUpload: function () {
            var el = $("input[name='image']", form);
            el.replaceWith(el.val('').clone(true));
        },

        /**
         * Снять сообщение об ошибке.
         *
         * @static
         */
        removeError: function () {
            EditFormObj.setError("image", "", false);
        }
    };

    /**
     * Список функций, обрабатывающих завершение асинхронных операций.
     *
     * @namespace
     */
    var asyncActions = {
        //TODO: удалить если надо imageType_async_verify, может и asyncActions
        imageType_async_verify: function () {
            if ($(".form-group.has-error [name='image']", form).length > 0) {
                //image.backState();
                image.clearUpload();
            }
        }
    };

    /**
     * Блокировка/разблокировка формы.
     *
     * @param {boolean} [block=true] - Блокировать или разблокировать форму.
     */
    this.blockForm = function (block) {
        if (typeof block === "undefined") {
            block = true;
        }
        if (typeof this.blockForm.blockCount == "undefined") {
            this.blockForm.blockCount = 0;
        }

        if (block) {
            ++this.blockForm.blockCount;
        } else {
            if (this.blockForm.blockCount) {
                --this.blockForm.blockCount;
            }
        }

        if (this.blockForm.blockCount) {
            $("fieldset", form).attr("disabled", "disabled");
        } else {
            $("fieldset", form).removeAttr("disabled");
        }

        return this.blockForm.blockCount;
    };

    form.on("async_action_start", function (e, name, func) {
        EditFormObj.blockForm();

        if (!EditFormObj.asyncActionElements) {
            EditFormObj.asyncActionElements = [];
        }

        EditFormObj.asyncActionElements.push({name: name, func: func, status: "start"});
    });

    form.on("async_action_end", function (e, name) {
        EditFormObj.blockForm(false);

        // Присвоение элементу завершенного статуса.
        for (var i in EditFormObj.asyncActionElements) {
            var elem = EditFormObj.asyncActionElements[i];
            if (elem.name == name && elem.status != "end") {
                //elem.status = "end";
                EditFormObj.asyncActionElements[i].status = "end";
                break;
            }
        }

        // Обработка элементов со значением "end" с конца.
        for (i = EditFormObj.asyncActionElements.length - 1; i >= 0; --i) {
            if (EditFormObj.asyncActionElements[i].status == "end") {
                if (EditFormObj.asyncActionElements[i].func) {
                    EditFormObj.asyncActionElements[i].func();
                } else {
                    if (asyncActions[EditFormObj.asyncActionElements[i].name]) {
                        asyncActions[EditFormObj.asyncActionElements[i].name]();
                    } else {
                        app.helper.log('Function wasn\'t found for async operation "'
                            + EditFormObj.asyncActionElements[i].name + '".');
                    }
                }
                EditFormObj.asyncActionElements.pop();
            } else {
                break;
            }
        }
    });

    $(":file", form).change(function () {
        if (!this.files) {
            alert($(this).attr("data-noSupportFileUpload-text"));
            return false;
        }

        image.saveState();

        // Валидация.
        if (EditFormObj.validators.image) {
            //var imgValidators = $.extend({}, EditFormObj.validators.image);
            var imgValidators = JSON.parse(JSON.stringify(EditFormObj.validators.image));
            for (var val in imgValidators) {
                if (!imgValidators[val].file) {
                    imgValidators[val].file = this.files[0];
                }
            }
            if (!EditFormObj.validation.validateByFunction("image", imgValidators)) {
                //image.backState();
                image.clearUpload();
                return false;
            }
        }

        image.removeError();
        image.showImage(this.files[0]);

        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.parents(".form-group").find(":text").val(label);
    });

    $('select[name="birth[day]"], select[name="birth[month]"], select[name="birth[year]"]', form)
        .change(function () {
            if ($(this).val() == -1) {
                this.selectedIndex = 0;
            }
        });

    $(".remove_uploaded_image", form).click(function () {
        image.removeError();
        image.backState();
    });

    $('[type="submit"]', form).click(function () {
        EditFormObj.trimElements(EditFormObj.elementsToTrim);
        EditFormObj.cleanMessages();

        // Для проверки на ошибки.
        // Устарело, надо использовать EditFormObj.blockForm.endBlockFunction для сабмита формы
        // - на случай асинхронных проверок значений.
        var resCommon = true;

        EditFormObj.form.trigger("async_action_start", ["submit", function () {
                if ($(".form-group.has-error", form).length > 0) {
                    alert($(".dyn_data.didntPassValidation", form).val());
                } else {
                    form.submit();
                }
            }]
        );

        for (var vName in EditFormObj.validators) {
            if (vName == 'image') {
                continue;   // Изображение будет проверяться во время попытки его открыть (установить в загрузку).
            }
            resCommon &= EditFormObj.validation.validateByFunction(vName, EditFormObj.validators[vName]);
        }

        EditFormObj.form.trigger("async_action_end", "submit");

        return false;
    });
};
