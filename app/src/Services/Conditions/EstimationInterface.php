<?php

declare(strict_types=1);

namespace FeeCalculator\Services\Conditions;

use FeeCalculator\Models\LoanProposal;

interface EstimationInterface
{
    public function estimateFee(LoanProposal $loanProposal): float;
}