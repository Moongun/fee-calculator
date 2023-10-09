<?php

declare(strict_types=1);

namespace FeeCalculator\Models;

use FeeCalculator\Enums\TermEnum;

class LoanProposal
{
    public function __construct(
        private float|int $amount,
        private TermEnum $term,
    ) {
    }

    public function getAmount(): float|int
    {
        return round($this->amount,2);
    }

    public function getTerm(): TermEnum
    {
        return $this->term;
    }
}