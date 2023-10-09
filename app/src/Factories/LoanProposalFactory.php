<?php

declare(strict_types=1);

namespace FeeCalculator\Factories;

use FeeCalculator\Enums\TermEnum;
use FeeCalculator\Exceptions\InvalidDataException;
use FeeCalculator\Models\LoanProposal;

class LoanProposalFactory
{
    private const MINIMUM_LOAN_AMOUNT = 1000;
    private const MAXIMUM_LOAN_AMOUNT = 20000;

    public static function createLoanProposal(float|int $amount, int $term): LoanProposal
    {
        if ($amount < self::MINIMUM_LOAN_AMOUNT || $amount > self::MAXIMUM_LOAN_AMOUNT) {
            throw new InvalidDataException('Loan amount should be from 1000 - 20000');
        }

        $termEnum = TermEnum::tryFrom($term);

        if (null === $termEnum) {
            throw new InvalidDataException('Term should be 12 or 24 months');
        }

        return new LoanProposal($amount, $termEnum);
    }
}