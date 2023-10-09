<?php

declare(strict_types=1);

namespace FeeCalculator\Services;

use FeeCalculator\Models\LoanProposal;

interface FeeCalculatorInterface
{
    public function calculate(LoanProposal $loanProposal): float;
}