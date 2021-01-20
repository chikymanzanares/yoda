<?php
declare(strict_types=1);

namespace Inbenta\SharedKernel\Application;


interface DtoResponse
{
    public function toArray() : array;
}
