# hiking-backend
部署版本連結：[https://hiking-backend.herokuapp.com/](https://hiking-backend.herokuapp.com/)

## 專案安裝步驟

```
npm i
composer i
cp .env.example .env
// (在.env填入環境變數，內容另貼於Trello)
php artisan migrate:fresh --seed 
php artisan passport:install
// (測試能否運作)
php artisan serve
```

### 若使用SQLITE的額外步驟
```
sudo apt-get install php-sqlite3
touch ./database/hiking.sqlite
```

## 身分驗證

### 帳密註冊
1. 發送POST /api/register，Body(x-www-form-urlencoded)需攜帶：

```
{
  "email": "(使用者輸入的email)",
  "password": "(使用者輸入的對應密碼)"
}
```
2. 回傳格式如下：
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...(TLDR)"
}
```
3. 前端若有設定自動攜帶上述token於headers，註冊後不必額外登入即可使用

### 建立個人資料
0. 前端需設定攜帶上述token於headers
1. 發送POST /api/profile，Body(x-www-form-urlencoded)需攜帶：
```
{
  "name": "姓名",
  "gender": "性別",
  "phone_number": "手機號碼",
  "birth": "生日",
  "live": "居住地"
}
```
2. 回傳格式如下：
```
{
  "Status":"Your profile is created!"
}
3. 錯誤的回應(代表要建立資料的帳號不存在)：
```
{
    "errer": "This account is missing!"
}

### 帳密登入
1. 發送POST /api/login，Body(x-www-form-urlencoded)需攜帶：

```
{
  "email": "(使用者輸入的email)",
  "password": "(使用者輸入的對應密碼)"
}
```
2. 回傳格式如下：
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...(TLDR)"
}
```
3. 前端需設定攜帶上述token於headers，才能成立登入狀態存取需驗證的API

### 登入測試
1. 以/api/index為例，驗證成功會收到：
```
{
    "Status": "Logged!"
}
```
2. token錯誤的回應：
```
{
    "Status": "incorrect token"
}
```

### 原生登入API(不建議使用)
1. 發送POST /oauth/token，Body(x-www-form-urlencoded)需攜帶：

```
{
  "grant_type": "password",
  "client_id": 2,
  "client_secret": "(值另貼於Trello)",
  "username": "(已註冊的email)",
  "password": "(上述的對應密碼)"
}
```
2. 回傳格式如下：
```
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9
    ...(TLDR)",
    "refresh_token": "def50200b8526c9dda9cf0012ff1f
    ...(TLDR)"
}
```
3. 之後存取需登入驗證的API時，發送請求需在Headers攜帶以下資訊：

```
{
  "Authorization": "Bearer (上一步"access_token"的完整字串)"
}
```

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

