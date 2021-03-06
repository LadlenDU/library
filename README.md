Библиотека.
-----------

**Описание**

Разработать приложение («Библиотека») предоставляющее:

 * Просмотреть список книг, издательств, авторов.
 * Осуществить поиск книг, с применением различных фильтров
 * Прокомментировать конкретную книгу
 * Просмотреть карточку автора
 * Посмотреть список книг, написанных более чем тремя авторами
 * Посмотреть на одной странице список самых продуктивных (кол-во книг в год), авторов для каждого издательства.

Дополнительные возможности для Администратора:

 * Аутентифицироваться в административной части приложения.
 * Создавать, регистрировать, удалять (с возможностью восстановления) издательства, авторов, книги миниатюры.
 * Модерировать комментарии, с отображением изменений у пользователей в реальном времени.

**Требования**

Инструменты:

 * Для хранения всех данных, включая изображения, использовать СУБД Mysql.
 * Версия PHP 5.3-5.6, допускается использование сторонних библиотек, но запрещено пользоваться полноценными Фреймворками: symfony, laravel, lumen, yii и подобными.
 * Веб-сервер Apache 2.2, Apache 2.4, nginx любой версии.
 * nodejs для реализации сервера организующего работу по протоколу WebSockets.
 
Приложение:

 * Верстка адаптивная с использованием Фреймворка bootstrap3
 * Миниатюры имеют следующие ограничения: jpg, png, размер не больше 200x200 px
 * Применение CRUD
 * Каждый запрос на удаление или изменение данных должен быть защищен от CSRF атак
 * Обновление комментариев к книге в реальном времени, с использованием технологии WebSockets
 * Перечень таблиц и полей – на усмотрение исполнителя, но со след. обязательными требованиями:
    * Комментарии имеют плоскую структуру, без ветвления.
    * Идентификаторы сущностей в БД не должны использовать для первичного ключа auto_increment поля.
    * Книга может быть написана несколькими авторами и иметь несколько изданий
    * Книга может быть выпущена разными издательствами
 * Форма поиска должна содержать следующие фильтры: часть названия, издательство, автор - один или несколько.
 * Результаты поиска можно передавать другим пользователям в виде ссылки
