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
        $logSql = config('softDDRequestLog.logSql',false);
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
        if (config('softDDRequestLog.addRunTimeHeader',false)){
            $response->header(config('softDDRequestLog.RunTimeHeader','X-RUNTIME'), $runTime);
        }

        $data = ['runTime' => $runTime];
        $data['request'] = [
            'uri' => $request->getUri(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'header' => $request->headers->all(),
            'params' => $request->all()
        ];
        if (config('softDDRequestLog.logInput',false)){
            $data['request']['input'] = file_get_contents('php://input');
        }
        $data['response'] = [
            'status' => $response->getStatusCode(),
            'header' => str_replace("\r\n", ';;', $response->headers),
        ];
        if (config('softDDRequestLog.logAll',false) || $request->expectsJson()|| $request->input('x_log')){
            $data['response']['body'] = $response->getContent();
        }
        if ($logSql){
            $data['sql'] = DB::getQueryLog();
            DB::flushQueryLog();
        }
        if ($logChannel = config('softDDRequestLog.logFile')) {
            Log::channel($logChannel)->info(config('softDDRequestLog.message','request'), $data);
        }else{
            Log::info(config('softDDRequestLog.message','request'), $data);
        }
        return $response;
    }
}
