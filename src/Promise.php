<?php
/**
 * Promise.php
 * @author cdyun(121625706@qq.com)
 * @date 2026/3/12 15:23
 */

declare (strict_types=1);

namespace think\composer;

class Promise
{
    public function then($callable)
    {
        $callable();
    }
}