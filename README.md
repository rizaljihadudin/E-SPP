# 📑 Description

It's a full stack E-SPP Application made using Laravel v.10

# Features ✨

```
- Multiple user (Operator, administrator, parent)
- Operator can add, edit, or delete parent users.
- Operator can add, update, or delete students.
- Operator can add, update, or delete School fees (SPP)
- Operator can add, update, or delete Billing
- Parent can add, update, or cancel Billing (https://github.com/andes2912/indobank)
- Parent can add payment method with 152 Indonesian banks data
- Notification Billing on Web Aplication and Whatsapp (use https://app.whacenter.com/)
- etc ( is under development)
```

# 💻 Tools & Stacks

-   Backend Stacks :
    -   [Laravel](https://laravel.com/) : Programming Language
    -   [MySQL](https://www.mysql.com/) : Database Management System

# 🛠️ How to Run Locally

-   Clone it

```
$ git clone https://github.com/rizaljihadudin/E-SPP.git
```

-   Go to directory

```
$ cd E-SPP
```

```
$ composer update
```

```
$ cp .env.example .env
```

```
$ php artisan migrate
```

```
$ php artisan serve
```
