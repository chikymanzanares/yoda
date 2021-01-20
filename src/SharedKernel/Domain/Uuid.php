<?php
declare(strict_types=1);

namespace Inbenta\SharedKernel\Domain;

use Exception;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid extends ValueObject
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return Uuid
     * @throws Exception
     */
    public static function create(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @param self|ValueObject $o
     *
     * @return bool
     */
    protected function equalValues(ValueObject $o): bool
    {
        return $this->value() == $o->value();
    }
}
