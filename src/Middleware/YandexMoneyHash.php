<?php


namespace Zzzaaa\LaravelYandexMoneyHttpNotify\Middleware;
use Closure;
use Illuminate\Http\Request;

class YandexMoneyHash
{

    const HASH_FORMAT = 'notification_type&operation_id&amount&currency&datetime&sender&codepro&notification_secret&label';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $shaAttributeFromYandex = $request->get('sha1_hash');
        $compareWithHash = $this->hash($request, config('services.yandex.notification_secret'));

        return $shaAttributeFromYandex === $compareWithHash ? $next($request) : abort(403);
    }

    /**
     * @param Request $request
     * @param string $secret
     * @return string
     */
    public function hash(Request $request, $secret)
    {
        $fields = array_fill_keys(explode('&', self::HASH_FORMAT), null);
        array_walk($fields, function(&$val, $field) use ($request){
            $val = $request->get($field);
        });

        $fields['notification_secret'] = $secret;
        $paramStr = implode('&', $fields);

        return sha1($paramStr);
    }


}