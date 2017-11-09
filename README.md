user-management
===============

**Подготовка проекта**

    git clone https://github.com/leckermaul/user-management.git 
    cd user-management/
    composer install
    docker-compose up
    bin/console doctrine:schema:update --force
    bin/console server:run


**Ограничения**:

1. Пользователь может относиться только к одной группе
2. Группы создаются пустыми (без пользователей) 
3. Группа должна быть создана перед тем, как в нее будет добавлен пользователь
4. Пользователей с одинаковым email и групп с одинаковым именем существовать не может

Документация находится по адресу /api/doc



