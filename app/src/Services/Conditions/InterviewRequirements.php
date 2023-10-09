<?php

declare(strict_types=1);

namespace FeeCalculator\Services\Conditions;

use FeeCalculator\Models\LoanProposal;

class InterviewRequirements implements EstimationInterface
{
    public function estimateFee(LoanProposal $loanProposal) : float
    {
        $fees = $loanProposal->getTerm()->getFees();

        if (in_array($loanProposal->getAmount(), array_keys($fees))) {
            return $this->roundFee($fees[$loanProposal->getAmount()]);
        }

        $lowerAmount = $this->getTermLoanAmountUnderLoanProposalAmount($loanProposal);
        $higherAmount = $this->getTermLoanAmountOverLoanProposalAmount($loanProposal);

        $fee = $fees[$lowerAmount] + (($fees[$higherAmount] - $fees[$lowerAmount]) / ($higherAmount - $lowerAmount)) * ($loanProposal->getAmount() - $lowerAmount);

        return $this->roundFee($fee);
    }

    private function getTermLoanAmountUnderLoanProposalAmount(LoanProposal $loanProposal): int
    {
        $loanAmounts = array_keys($loanProposal->getTerm()->getFees());

        return array_reduce(
            $loanAmounts,
            static fn (int $minLoanAmount, int $nextLoanAmount): int => $nextLoanAmount < $loanProposal->getAmount() ? $nextLoanAmount : $minLoanAmount,
            $loanAmounts[0]
        );
    }

    private function getTermLoanAmountOverLoanProposalAmount(LoanProposal $loanProposal): int
    {
        $loanAmounts = array_keys($loanProposal->getTerm()->getFees());

        return array_reduce(
            $loanAmounts,
            static fn (int $maxLoanAmount, int $nextLoanAmount): int => $maxLoanAmount > $loanProposal->getAmount() ? $maxLoanAmount : $nextLoanAmount,
            $loanAmounts[0]
        );
    }

    private function roundFee(int|float $fee): float
    {
        // Round up the fee to ensure fee + loan amount is an exact multiple of 5
        return ceil($fee / 5) * 5;
    }
}