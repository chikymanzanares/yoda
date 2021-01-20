<?php
declare(strict_types=1);

namespace Inbenta\SharedKernel\Domain;

use DateTime;
use DateTimeImmutable;

abstract class AggregateRoot
{
    /**
     * @var Uuid
     */
    protected $id;

    /**
     * @var DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * AggregateRoot constructor.
     */
    protected function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }


    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
