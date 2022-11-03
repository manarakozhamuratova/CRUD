# Задача
Необходимо доработать сервис админки объявлений, расположенный в этом же репозитории.
Создание сервиса и его запуск описывается в статье: [https://github.com/Kolesa-Education/php-service-practice-article](https://github.com/Kolesa-Education/php-service-practice-article)

**3 обязательные подзадачи**:
- Реализовать просмотр страницы объявления
- Реализовать редактирование объявления
- Отрефакторить репозиторий на хранение объявлений в mySQL вместо json-файлов.

**2 дополнительные подзадачи**:
- Добавить в объявление категорию
- Добавить поиск по базе данных

Эти задачи помогут заполучить дополнительные баллы, если вы уже справились с обязательными

### Подзадача 1. Просмотр страницы объявлений
Нужно создать новый роут `GET /adverts/{id}` и его обработчик , который позволяет выводить страницу объявления, содержащую:
- Заголовок
- Описание
- Цену

**Требования:**
- По адресу `/adverts/1` выводится объявление с id 1 и его поля

****
###  Подзадача 2. Редактирование объявлений
Доработать сервис таким образом, чтобы с его помощью можно было редактировать объявления.

Для этого потребуются два новых роута:
- `GET /adverts/{id}/edit`
- `PATCH /adverts/{id}` или `POST /adverts/{id}/edit`

Для этого можно использовать ту же форму, что и для создания объявлений. Но кроме обычных полей, она должна содержать скрытое поле с id объявления, который будет служить его идентификатором.

Так-же можете воспользоваться HTTP-методом PATCH, хотя и HTML-формы его не поддерживают, ограничение можно обойти с помощью конструкции:
```html
<form action="/adverts" method="post">
    <input type="hidden" name="_METHOD" value="PATCH">
    ...
</form>
```

**Требования:**
- По адресу /adverts/1/edit, выводится редактирование объявления с id 1
- В полях должны быть предзаполнены актуальные данные
- Данные объявления обновляются после редактирования

****

### Подзадача 3. Перенести хранение данных из файлов в реляционную базу данных
Для этого нужно поднять базу данных, создать таблицу `adverts` с соответсвующими полями и подключиться к ней. Для этого в PHP существует встроенный класс [PDO](https://www.php.net/manual/ru/book.pdo.php).

Правки вносятся в AvertRepository.

Реализация подключения и запросов на ваше усмотрение.

В этом задании вам так-же необходимо добавить файл с SQL-запросом на создание схемы в базе. Будет очень хорошо, если попробуете воспользоваться миграциями. Можно воспользоваться готовым решением, например [Doctrine](https://www.doctrine-project.org/projects/doctrine-migrations/en/3.5/reference/introduction.html#composer) или написать CLI-скрипт, который будет выполнять создание таблиц.

Постарайтесь позаботиться о безопасности и не допустить возможности совершения SQL-инъекций.

**Требования:**
 - В проект добавлена директория и файл с SQL-запросами, а ещё лучше - миграция.
 - Сервис соединяется с базой в MySQL
 - Сервис получает и сохраняет данные объявления в MySQL
 - Весь функционал по сохранению, обновлению и отображению данных, сделанный в предыдущих задачах работает.

****

### Дополнительная подзадача 1. Новое поле "Категория"
Добавить в объявление новое поле `Категория`, которое будет отвечать за то, в какой категории будет находиться объявление, например ("Электроника", "Мебель", "Недвижимость", "Транспорт").

**Требования:**
- Вывод категории в списке объявлений и на странице объявления
- В форме создания и реадктирования есть возможность выбора категории с помощью HTML-тега `select`
- Валидация на существование категории

****

### Дополнительная подзадача 2. Поиск
Добавить на страницу `/adverts` форму поиска, содержащую 2 поля:
- search
- category

В методе `AdvertController::index` сделать обработку этих значений.

**Условия поиска:**
- Фраза, переданная в search должна быть в заголовке объявления. Регистр не имеет значения. Алгоритм поиска на ваше усмотрение.
- Категория должна точно соответствовать той, что установлена в объявлении

**Требования:**
- При поисковой фразе `iPhone 13` должны быть выведены объявления с заголовком `Продам новый iPhone 13`
- При пустой поисковой фразе и значении `Категория: Электроника`, должны выводиться объявления из соответсвующей категории.

****

### Срок до 2 ноября 2022г. 18:00

****

## Полезные ссылки
- [Документация Slim](https://www.slimframework.com/docs/v4/)
- [Интерфейсы PSR-7](https://www.php-fig.org/psr/psr-7/)
- [RESTful Routing](https://www.learnhowtoprogram.com/c-and-net/basic-web-applications/introduction-to-restful-routing)
- [Как работать с PDO?](https://phpfaq.ru/pdo)
- [PDO официальная документация](https://www.php.net/manual/ru/book.pdo.php)
- [Doctrine - миграции в БД](https://www.doctrine-project.org/projects/doctrine-migrations/en/3.5/reference/introduction.html#composer)