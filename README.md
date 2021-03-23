# hiking-backend
部署版本連結：[https://gohiking-server.herokuapp.com](https://gohiking-server.herokuapp.com)

## 專案安裝步驟

```
npm i // 安裝node.js套件，內建畫面模板使用的
composer i // 安裝php套件，後端用到的
cp .env.example .env // 並在.env填入環境變數
php artisan key:generate // 產生網站專屬密鑰(寫入.env環境變數)，確保加密資料安全性(跳過這步網站會無法運作)

php artisan migrate:fresh --seed // 將資料庫初始化，且有seeder時會載入(重複執行會清空資料)
php artisan passport:install // 建立產生安全Access Token 的加密金鑰，才能執行
php artisan serve // 測試能否運作
```

### 若使用SQLITE的額外步驟
```
sudo apt-get install php-sqlite3 // 以Ubuntu為例，其他作業系統則是安裝對應版本的sqlite
touch ./database/database.sqlite
// 將.env的DB_CONNECTION=mysql改成DB_CONNECTION=sqlite，SESSION_DRIVER=database改成SESSION_DRIVER=file
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
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...(TLDR)",
    "userId": "8"
}
```
3. 前端若有設定自動攜帶上述token於headers，註冊後不必額外登入即可使用
4. 錯誤的回應(代表電子郵件已被註冊)，並回傳404狀態碼：
```
{
    "error": "wrong email or password!"
}
```

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
  "status":"your profile is created!"
}
```
3. 錯誤的回應(代表要建立資料的帳號不存在)，並回傳401狀態碼：
```
{
    "error": "this account is missing!"
}
```

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
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...(TLDR)",
    "userId": "8"
}
```
3. 前端需設定攜帶上述token於headers，才能成立登入狀態存取需驗證的API
4. 錯誤的回應(代表登入失敗)，並回傳401狀態碼：
```
{
    "error": "wrong email or password!"
}
```

### 第三方登入
0. 目前僅支援Facebook、Google、Apple，需由前端向社群平台驗證後取得帳戶資料
1. 發送POST /api/auth/social/callback，Body(x-www-form-urlencoded)需攜帶：

```
{
  "name": "姓名",
  "email": "電子郵件地址",
  "facebook_id": "(id部分僅會因應社群平台來源，只傳其中一個)",
  "google_id": "(id部分僅會因應社群平台來源，只傳其中一個)",
  "apple_id": "(id部分僅會因應社群平台來源，只傳其中一個)",
  "avatar": "大頭貼",
  "token": "(用於產生密碼雜湊)"
}
```
2. 回傳格式如下：
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...(TLDR)",
    "userId": "8"
}
```

### 登入測試
1. 以發送GET /api/index為例，驗證成功會收到：
```
{
    "status": "logged!"
}
```
2. token錯誤的回應：
```
{
    "status": "incorrect token"
}
```

### 忘記密碼
1. 發送POST /api/password/forget，Body(x-www-form-urlencoded)只需攜帶：

```
{
  "email": "(使用者輸入的email)"
}
```
2. 回傳格式如下：
```
{
    "message": "已寄送驗證碼到指定信件！"
}
```
3. 同時，只要查有對應帳號的信箱，也會用電子郵件發送4位數字的驗證碼(如4, 3, 2, 1)，主旨為：請確認修改密碼

### 確認驗證碼
1. 發送POST /api/password/confirm，Body(x-www-form-urlencoded)需攜帶：

```
{
  "verificationCode0": "(第0個驗證碼(以陣列方式計算)",
  "verificationCode1": "(第1個驗證碼(以陣列方式計算)",
  "verificationCode2": "(第2個驗證碼(以陣列方式計算)",
  "verificationCode3": "(第3個驗證碼(以陣列方式計算)",
}
```
2. 若驗證碼與電子郵件的一致，給予登入的權限，回傳格式如下：
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...(TLDR)"
}
```
3. 錯誤的回應(代表驗證碼錯誤)，並回傳401狀態碼：
```
{
    "error": "wrong verification codes!"
}
```

### 重設密碼
0. 前端需設定攜帶token於headers
1. 發送POST /api/password/change，Body(x-www-form-urlencoded)需攜帶：
```
{
  "password": "(欲重設的密碼)"
}
```
2. 回傳格式如下：
```
{
  "status":"your password has been changed!"
}
```
3. 錯誤的回應(代表要建立資料的帳號不存在)，並回傳401狀態碼：
```
{
    "error": "this account is missing!"
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
