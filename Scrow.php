<?php
$f1 = function ($request,  $next) {
    $request[] = "THIS IS F1";
    return $next($request);
};

$f2 = function ($request,  $next) {
    $request[] = 'THIS IS F2';
    return $next($request);
};

function f3 ($request,  $next) {
    $request[] = 'THIS IS F3';
    return $next($request);
};

$list = [$f1, $f2, 'f3'];

class n{
    public $r = [];
    public function __invoke($r)
    {
        $this->r = $r;
        return $this;
    }
}

$r = [];
$next = new n();

foreach ($list as $item) {
    $next = call_user_func_array($item, [$r, $next]);
    if (!$next) break;
    $r = $next->r;
}

var_dump($r);
