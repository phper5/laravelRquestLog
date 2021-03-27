# softdd/requestlog
记录用户请求请求
# Installation
<pre>
return [
    'logSql'=>true,
    'addRunTimeHeader'=>true,
    'RunTimeHeader'=>'X-RUNTIME',
    'logInput'=>false,
    'logFile'=>'request',
    'message'=>'request'
];
</pre>
- logSql 是否记录sql
- addRunTimeHeader  是否添加运行时间到header
- RunTimeHeader  运行时间的header标签
- logInput 是否记录php://input
- logFile log文件
- message  消息
