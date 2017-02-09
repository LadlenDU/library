"use strict";   //TODO: не надо ли убрать "use strict" ???
//TODO: добавить комментарии в ф-ях ниже
/** @type {Object} - Содержит общие вспомогательные функции. */
app.helper = {};

/**
 * Запись в консоль (если работает).
 *
 * @function log
 * @param {string} msg - Строка для записи.
 */
app.helper.log = function (msg) {
    if (console && console.log) {
        console.log(msg);
    }
};

/**
 * Возвращает параметр из текущего URL.
 *
 * @function getUrlParam
 * @param {string} name - Название параметра.
 * @returns {string} - Значение параметра, null если параметр не указан, пустая строка если не установлен.
 */
app.helper.getUrlParam = function (name) {
    // TODO: возможно стоит переместить функцию в window.location.href.prototype
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
        return null;
    } else {
        return results[1] || '';
    }
};

app.helper.checkCookieEnabled = function () {
    var cookieEnabled = navigator.cookieEnabled;
    if (!cookieEnabled) {
        document.cookie = "testcookie";
        cookieEnabled = document.cookie.indexOf("testcookie") != -1;
    }
    return cookieEnabled;
};

app.helper.implode = function (glue, pieces) {
    return ((pieces instanceof Array) ? pieces.join(glue) : pieces);
};

app.helper.extend = function (Child, Parent) {
    var F = function () {
    };
    F.prototype = Parent.prototype;
    Child.prototype = new F();
    Child.prototype.constructor = Child;
    Child.superclass = Parent.prototype;
};

/**
 * Добавляет JS файл в конец <head> (если ещё не добавлен).
 *
 * @param {string} path - Путь к файлу.
 */
/*app.helper.appendJsFile = function(path) {
 if (!this.appendedJsFiles) {
 this.appendedJsFiles = [];
 }

 //Object.getPrototypeOf(this).

 path = path.trim();

 if (this.appendedJsFiles.indexOf(path) == -1) {
 var imported = document.createElement('script');
 imported.src = path;
 document.head.appendChild(imported);

 this.appendedJsFiles.push(path);
 }
 else
 {
 app.helper.log("Attempt to include JS file '" + path + "' when it have already been included.");
 }
 }*/
//app.helper.appendJsFile.appendedJsFiles =

/*,
 ifJson: function (data) {
 try {
 jQuery.parseJSON(data)
 return true;
 } catch (e) {
 return false;
 }
 },*/

/*,
 showError: function (data) {
 alert("Произошла ошибка: " + data);
 this.logInfo("Error: " + data);
 },
 implode: function (glue, pieces) {
 return ((pieces instanceof Array) ? pieces.join(glue) : pieces);
 },*/
/**
 * Вставка параметра URL
 */
/*insertUrlParam: function (urlParams, key, value) {
 key = encodeURI(key);
 value = encodeURI(value);

 var kvp = urlParams.split('&');

 var i = kvp.length;
 var x;
 while (i--) {
 x = kvp[i].split('=');

 if (x[0] == key) {
 x[1] = value;
 kvp[i] = x.join('=');
 break;
 }
 }

 if (i < 0) {
 kvp[kvp.length] = [key, value].join('=');
 }

 if (kvp[0] == "") {
 kvp.shift();
 }

 return kvp.join('&');
 }*/

//TODO: возможно, не следует менять прототипы из соображений производительности

if (!String.prototype.trim) {
    (function () {
        /**
         * Вырезает BOM и неразрывный пробел с начала и конца строки.
         *
         * @returns {string}
         */
        String.prototype.trim = function () {
            return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
        };
    })();
}

if (!String.prototype.sprintf) {
    (function () {
        /**
         * Заменяет значения '%s' в строке на параметры функции что идут после параметра строки.
         *
         * @param {...string} - Подставляемые аргументы.
         * @returns {string} - Модифицированная строка.
         */
        String.prototype.sprintf = function () {
            //return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
            var modStr = this.toString();
            for (var i = 0; i < arguments.length; i++) {
                modStr = modStr.replace("%s", arguments[i]);
            }
            return modStr;
        };
    })();
}

/*app.helper.fsprint = function(str) {
 var modStr = str;
 for (var i = 1; i < arguments.length; i++) {
 modStr = modStr.replace("%s", arguments[i]);
 }
 return modStr;
 }*/

// TODO: избавиться от этого
/*$(function () {
 var data = {ajax: 1};
 data[$('meta[name="csrf-param"]').attr("content")] = $('meta[name="csrf-token"]').attr("content");
 if (app.helper.getUrlParam("debug")) {
 data["debug"] = 1;
 }
 $.ajaxSetup({
 //cache: false,
 type: "POST",
 data: data
 });
 });*/

