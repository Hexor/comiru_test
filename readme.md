### 后端简易部署指南
1. 直接从 Github 上下载项目解压, 或者执行 <br>
    ```git clone git@github.com:Hexor/comiru_test.git``` 
2. 进入项目文件夹 <br>
    ```cd comiru_test```
3. 安装所有项目所需的 composer 包 <br>
    ```composer install```
4. 配置 ```.env``` 环境 <br>
     a. ```cp .env.example .env``` <br>
     b. 修改 ```.env``` 中的数据库配置并保存 <br>
     c. 修改 ```.env``` 中的 ```APP_URL``` 配置并保存 <br>
     d. 执行 ```php artisan key:generate``` 
5. 生成数据库表 <br>
    ```php artisan migrate```
6. 安装 Laravel Passport <br>
    ```php artisan passport:install``` <br>
    这条命令会有类似这样的输出
    ```
    Personal access client created successfully.
    Client ID: 1
    Client Secret: BJkmAZyp6BjbCDH0ckqKXmr01W7TSfXonkCKliLD
    Password grant client created successfully.
    Client ID: 2
    Client Secret: bqSA45dzJYmzIuOBRwGfKZPAvbIzipJr2251vIVX
    ```
    保存这个 Client ID 为 2 的 Client Secret 字符串, 并写入 ```.env``` 文件的 
    ```PASSPORT_CLIENT_SECRET``` 和 ```PASSPORT_CLIENT_ID``` 字段.   设置好之后, ```.env``` 将包含以下内 <br>
    ```
    PASSPORT_CLIENT_SECRET=bqSA45dzJYmzIuOBRwGfKZPAvbIzipJr2251vIVX
    PASSPORT_CLIENT_ID=2
    ```
7. 如需实现 Line 登录, 还需要去 ```.env``` 中配置以下参数, 这些参数将从 Line 开发者控制台中获取
    ```
   LINE_CLIENT_SECRET=
   LINE_CLIENT_ID=
   ```
   假设刚刚设置的 ```APP_URL``` 为 ```http://abc.com```, 在 Line 开发者后台中, 需要将 
   redirect uri 设置为 ```http://abc.com/api/line_auth_callback``` 
   
8. 如需实现 Bot 信息推送, 则需要配置 ```supervisor```, 具体配置方式请参照 Laravel 队列的 [官方文档](https://laravel.com/docs/5.5/queues) . 同时还需要去 ```
.env``` 中配置以下参数, 
该参数将从 
Line 
开发者控制台中获取
    ```
    LINE_BOT_TOKEN=
    ```
    
    
    
### 前端简易部署指南
1. 安装 quasar 前端框架, 点击查看 [安装指南](https://v1.quasar-framework.org/quasar-cli/installation) .需要注意的是, 需要安装的是 v1.0+ 版本, 而不是旧的 0.* 版本
    
    安装完成后, 命令行中运行 ```quasar -v``` ,可以看到输出的版本号, 应该为 1.0 以上的版本 
2. 直接从 Github 上下载项目解压, 或者执行 <br>
   ```git clone git@github.com:Hexor/comiru_test_front.git```
   
   需要注意的是, 前端项目文件夹需要和后端项目文件夹在同一文件夹下, 比如前端项目和后端目录的结构为
   ```
       ../xxx/comiru_test 后端项目
       ../xxx/comiru_test_front 前端项目
   ```
3. 进入前端项目目录 ```cd comiru_test_front``` 并执行 ```npm install```
4. 替换 ```../src/boot/gConfig.js``` 中 ```openLineLoginWindow``` 方法内的 
Line 登录跳转地址, 请参考 Line 开发者文档获取该地址
    如果不需要line 登录, 此步骤可省略
5. 替换 ```../src/boot/axios.js``` 中的 ```baseURL```, 比如当后端项目的 ```APP_URL``` 为 
```http://abc.com``` 时, ```baseURL```就要设置成 
```http://abc.com/api/```
6. 替换 ```../quasar.conf.js``` 内的 ```APP_URL```, 与后端项目保持一致, 比如 ```http://abc.com```
7. 在前端项目内执行 ```quasar dev``` 即可单独运行本地前端项目
8. 在前端项目内执行 
    ```
    quasar build; cp -r ../comiru_front_dist/. ../comiru_test/public"
    ```
    即可 build 前端项目, 同时将build生成的代码直接复制到后端 laravel 项目中