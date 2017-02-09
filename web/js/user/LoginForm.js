"use strict";

/**
 * Форма логина пользователя.
 *
 * @class LoginForm
 *
 * @param {jQuery} form - Объект формы.
 */
app.user.LoginForm = function (form) {

    var LoginFormObj = this;

    // Вызов родительского конструктора.
    app.user.LoginForm.superclass.constructor.call(this, form);

    function checkValue(name)
    {
        var ret = true;

        var elem = $('input[name="' + name + '"]');
        if (!elem.val())
        {
            LoginFormObj.setError(elem);
            $('input[name="' + name + '"]' + " + .help-block-error").html($(".str-required_field", form).val());
            ret = false;
        }

        return ret;
    }

    $(".login_form").submit(function () {
        var ret = true;

        LoginFormObj.cleanMessages();
        LoginFormObj.trimElements(LoginFormObj.elementsToTrim);

        ret = ret && checkValue("login");
        ret = ret && checkValue("password");

        /* Углубленно проверять особо нечего и даже не желательно, лучше обойтись только проверкой на наличие.
        for (var vName in LoginFormObj.validators) {
            LoginFormObj.validation.validateByFunction(vName, LoginFormObj.validators[vName]);
        }*/

        return ret;
    });
};
