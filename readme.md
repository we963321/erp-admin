

## 安装

- git clone 到本地
- 执行 `composer install`,创建好数据库
- 配置 **.env** 中数据库连接信息,没有.env请复制.env.example命名为.env
- 执行 `php artisan key:generate`
- 执行 `php artisan migrate:refresh --seed`
- 键入 '域名/admin/login'(后台登录)
- 默认后台账号:admin@gmail.com 密码:123456

## Location 地區

地區資料+++

```sh
    php artisan db:seed --class="LocationSeeder"
```