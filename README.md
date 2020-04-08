    Пишем свой феймворк
1. Создаем файловую структуру <b>MVC</b>.
2. Создаем файл <b>.htaccess</b> : прописываем настройки apache
3. Создаем точку входа в приложение <b>index.php</b> : \
    a) Реализуем автозугрузку в точке входа. \
    b) Запускаем сессию. \
    с) Разбиваем url на массив
4. Создаем <b>Router</b>: в методе route разбираем url на имя контроллера, его действие и параметры
    Пример: http://localhost/pilot/users/show/1 \
    Имя контроллера UsersController, экшен - show, параметр - 1
5. Дополняем <b>Application</b>
6. Создаем <b>Controller</b>
7. Создаем <b>View</b> таким образом, чтобы в нем были необходимые методы для работы с интерфейсом + метод render
8. Делаем дефолтный layout + вид для HomeController
9. Одна из сложных частей: <b>паттерн singleton БД</b>: \
    a) Создаем класс <b>DB</b> \
    b) Инкапсулируем свойства и метод конструктора \
    c) Заполняем класс нужными методами
10. Создаем класс <b>Model</b>: \
    a) Разбираемся со свойствами класса (нужны статические свойства: сама бд, название таблицы + softDeletes) \
    b) В конструкторе разбираемся с modelName property \
    c) Реализуем методы класса Model,<b>чтобы они были на уровень выше</b> методов класса DB.
11. Создаем класс </b>Filesystem</b>
12. Создаем новую директорию под Validators: \
    a) Создаем абстрактный класс <b>Validator</b> \
    b) Создаем классы валидации, которые нам нужны.
13. Классы <b>Session и Cookie</b> для непосредственной работы с ними.
14. Класс <b>Input</b>, в основном для проверки метода запроса.
* Все функции-хелперы находятся в директории <b>/lib/helpers</b>

   
    Написание моделей, контроллеров и представлений на основе фреймворка.
    
1.  <b>HomeController</b>, что редиректит нас на home
2.  Модели пользователя и логина. \
    Модель логина принимает только валидацию. Наполняем модель пользователя необходимыми методами.
3. В моем случае <b>RegisterController</b> берет на себя роль не только регистрации, но и логина (в том числе logout)
4. <b>ProfileController</b> возвращает представление залогиненного пользователя.
5. !!! На данный момент логику работы с файлами я оставил в ProfileController (что не есть верно, нарушение принципа <b>SOLID</b>)
6. Добавлен русский язык (!необходимо в дальнейшем переделать и опробовать другой подход)


    Для того, чтобы запустить проект, необходимо:

1. Запустить <b>XAMPP</b>
2. Заходим на <b>/localhost/phpmyadmin/</b>
3. Создаем БД (у меня) <b>pilot</b>
4. Сгенерировать таблицу: \
CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(150) NOT NULL,
 `email` varchar(150) NOT NULL,
 `fname` varchar(150) NOT NULL,
 `lname` varchar(150) NOT NULL,
 `password` varchar(255) NOT NULL,
 `file` varchar(500) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
 `deleted` tinyint(4) NOT NULL DEFAULT 0,
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`),
 UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4
5. Если у вас другие данные БД, то их можно спокойно найти в <b>/app/config/config.php</b>
6. Заходим на <b>/localhost/pilot/</b>
