<?php
/**
 * Created by PhpStorm.
 * User: white
 * Date: 12/11/18
 * Time: 2:29 PM
 */

namespace SoftDD\RequestLog;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RequestLog
{
    public function handle($request, Closure $next)
    {
        $logSql = config('dd-requestLog.logSql',false);
        if ($logSql){
            DB::connection()->enableQueryLog();
        }

        //开始的处理
        $startTime = intval(microtime(true) * 1000);

        $response = $next($request);
        $endTime = intval(microtime(true) * 1000);
        if ($response instanceof  RedirectResponse) {
            return $response; //to check!
        }
        $runTime = $endTime - $startTime;
        if (config('dd-requestLog.addRunTimeHeader',false)){
            $response->header(config('dd-requestLog.RunTimeHeader','X-RUNTIME'), $runTime);
        }

        $data = ['runTime' => $runTime];
        $data['request'] = [
            'uri' => $request->getUri(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'header' => $request->headers->all(),
            'params' => $request->all()
        ];
        if (config('dd-requestLog.logInput',false)){
            $data['request']['input'] = file_get_contents('php://input');
        }
        $data['response'] = [
            'status' => $response->getStatusCode(),
            'header' => str_replace("\r\n", ';;', $response->headers),
            'body' => $response->getContent(),
        ];
        if ($request->expectsJson()){
            $data['response']['body'] = $response->getContent();
        }
        if ($logSql){
            $data['sql'] = DB::getQueryLog();
            DB::flushQueryLog();
        }
        if ($logChannel = config('dd-requestLog.logFile')) {
            Log::channel($logChannel)->info(config('dd-requestLog.message','request'), $data);
        }else{
            Log::info(config('dd-requestLog.message','request'), $data);
        }
        return $response;
    }
}