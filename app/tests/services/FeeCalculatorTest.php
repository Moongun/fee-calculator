<?php

declare(strict_types=1);

namespace services;

use FeeCalculator\Exceptions\InvalidDataException;
use FeeCalculator\Factories\LoanProposalFactory;
use FeeCalculator\Services\Conditions\InterviewRequirements;
use FeeCalculator\Services\FeeCalculator;
use PHPUnit\Framework\TestCase;

class FeeCalculatorTest extends TestCase
{
    /**
     * @dataProvider provideValidData
     */
    public function testCalculate(int|float $amount, int $term, float $expectedFee): void
    {
        $loanProposal = LoanProposalFactory::createLoanProposal($amount, $term);

        $calculator = new FeeCalculator(new InterviewRequirements());
        $fee = $calculator->calculate($loanProposal);

        $this->assertSame($expectedFee, $fee);
    }

    /**
     * @dataProvider provideInvalidData
     */
    public function testInvalidData(int|float $amount, int $term): void
    {
        $this->expectException(InvalidDataException::class);

        LoanProposalFactory::createLoanProposal($amount, $term);
    }

    public static function provideInvalidData(): array
    {
        return [
            'too low loan amount' => ['amount' => 1, 'term' => 12],
            'too high loan amount' => ['amount' => 10000000, 'term' => 12],
            'term out of bound' => ['amount' => 1000, 'term' => 123],
        ];
    }

    public static function provideValidData(): array
    {
        return [
            ['amount' => 1000, 'term' => 12, 'expectedFee' => 50.0],
            ['amount' => 2000, 'term' => 12, 'expectedFee' => 90.0],
            ['amount' => 2500, 'term' => 12, 'expectedFee' => 90.0],
            ['amount' => 3000, 'term' => 12, 'expectedFee' => 90.0],
            ['amount' => 4000, 'term' => 12, 'expectedFee' => 115.0],
            ['amount' => 5000, 'term' => 12, 'expectedFee' => 100.0],
            ['amount' => 5100, 'term' => 12, 'expectedFee' => 105.0],
            ['amount' => 6000, 'term' => 12, 'expectedFee' => 120.0],
            ['amount' => 7111, 'term' => 12, 'expectedFee' => 145.0],
            ['amount' => 8000.111111111, 'term' => 12, 'expectedFee' => 165.0],
            ['amount' => 9000, 'term' => 12, 'expectedFee' => 180.0],
            ['amount' => 10000, 'term' => 12, 'expectedFee' => 200.0],
            ['amount' => 19000, 'term' => 12, 'expectedFee' => 380.0],
            ['amount' => 20000, 'term' => 12, 'expectedFee' => 400.0],
            ['amount' => 1000, 'term' => 24, 'expectedFee' => 70.0],
            ['amount' => 2000, 'term' => 24, 'expectedFee' => 100.0],
            ['amount' => 3000, 'term' => 24, 'expectedFee' => 120.0],
            ['amount' => 4000, 'term' => 24, 'expectedFee' => 160.0],
            ['amount' => 9000, 'term' => 24, 'expectedFee' => 360.0],
            ['amount' => 10000, 'term' => 24, 'expectedFee' => 400.0],
            ['amount' => 11000, 'term' => 24, 'expectedFee' => 440.0],
            ['amount' => 17000, 'term' => 24, 'expectedFee' => 680.0],
            ['amount' => 18000, 'term' => 24, 'expectedFee' => 720.0],
            ['amount' => 19000, 'term' => 24, 'expectedFee' => 760.0],
            ['amount' => 20000, 'term' => 24, 'expectedFee' => 800.0],
        ];
    }
}
