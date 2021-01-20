<?php
declare(strict_types=1);

namespace Inbenta\SharedKernel\Application\QueryBus;


use Inbenta\SharedKernel\Application\DtoResponse;

interface QueryHandler
{
    /**
     * @param Query $query
     * @return mixed
     */
    public function __invoke(Query $query) : DtoResponse;
}
