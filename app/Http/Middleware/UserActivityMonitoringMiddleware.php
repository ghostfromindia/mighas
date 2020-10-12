<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class UserActivityMonitoringMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $this->track($request, $response);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    protected function track($request, $response)
    {
        $activity = new Activity;
        $activity['request_token'] = trim(str_ireplace('Bearer', '', $request->header('Authorization')));
        if (Auth::check()) {
            $user = Auth::user();
            $activity->user_id = intval($user->id);
        }
        else
        {
            $activity->guest_id = \Session::getId();
        }
        $activity->url = $request->getUri();
        $activity->ip = $request->ip();
        $activity->user_agent = $request->header('User-Agent');
        $activity->response_http_code = intval($response->getStatusCode());
        $activity->response_time = $this->getResponseDispatchTimeHumanized();
        $activity->response = $response->getContent();
        $activity->payload = $this->getRequestPayload();
        $activity->save();
        return true;
    }

    protected function getResponseDispatchTimeHumanized()
    {
        $timeTaken = microtime(true) - LARAVEL_START;
        return number_format($timeTaken, 2) . ' seconds';
    }

    /**
    * @return array
    */
    protected function getRequestPayload()
    {
        $payload = [];

        if (\Request::isMethod('GET')) {
            $payload = \Request::query();
        }

        if (\Request::isMethod('POST')) {
            $payload = array_merge($payload, \Request::input());
        }

        return json_encode($payload);
     }
}
