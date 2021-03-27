# SoftDD/RequestLog
记录用户请求请求
# Installation
- 复制本扩展到根目录的packages下，
 - 修改composer.json 增加： 
 ```   
 "psr-4": {
             "DiandiSoft\\ApiHeader\\": "packages/diandi-apiheader/src/"
         }
```
  - 执行
  ```
  composer dumpautoload
  ```
  在Kernel中增加中间件:
  
  \DiandiSoft\ApiHeader\ApiHeader::class,
