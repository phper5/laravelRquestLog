# softdd/requestlog
记录用户请求请求
## Installation
```bash
composer require softdd/requestlog
php artisan vendor:publish --provider="SoftDD\RequestLog\RequestLogServiceProvider"
```
## Usage
添加到中间件，请选择合适的groups
```php
// app/Http/Kernel.php

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...
        \SoftDD\RequestLog\RequestLog::class
    ];
    
    // ...
}
```
### 配置说明
```php
//softDDRequestLog.php
return [
    'logSql'=>true,
    'addRunTimeHeader'=>true,
    'RunTimeHeader'=>'X-RUNTIME',
    'logInput'=>false,
    'logFile'=>'request',
    'message'=>'request'
];
```
- logSql 是否记录sql
- addRunTimeHeader  是否添加运行时间到header
- RunTimeHeader  运行时间的header标签
- logInput 是否记录php://input
- logFile log文件
- message  消息
