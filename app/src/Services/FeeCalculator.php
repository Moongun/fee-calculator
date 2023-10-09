<?php

declare(strict_types=1);

namespace FeeCalculator\Services;

use Exception;
use FeeCalculator\Models\LoanProposal;
use FeeCalculator\Services\Conditions\EstimationInterface;

class FeeCalculator implements FeeCalculatorInterface
{
    public function __construct(
        private EstimationInterface $estimation,
    ) {
    }

    public function calculate(LoanProposal $loanProposal): float
    {
        try {
            return $this->estimation->estimateFee($loanProposal);
        } catch (Exception $exception) {
            // Exception should be logged and handled here...
            print $exception->getMessage();
        }
    }
}