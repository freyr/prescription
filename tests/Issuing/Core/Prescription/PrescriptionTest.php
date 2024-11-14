<?php

declare(strict_types=1);

namespace Freyr\Prescription\Tests\Issuing\Core\Prescription;

use Freyr\Prescription\Issuing\Core\Medicine\Dosage;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineId;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineRepository;
use Freyr\Prescription\Issuing\Core\Patient\Patient;
use Freyr\Prescription\Issuing\Core\Physician\Physician;
use Freyr\Prescription\Issuing\Core\Prescription\Prescription;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class PrescriptionTest extends TestCase
{


    public static function providePrescriptionConfiguration(): Generator
    {
        yield 'sciezka 1' => [

            'checkResult' => true,
            'assertSwitch' => 'assert',

        ];
        yield 'sciezka dwa' => [
            'checkResult' => false,
            'assertSwitch' => 'exception',
        ];
    }

    #[Test]
    #[DataProvider('providePrescriptionConfiguration')]
    #[TestDox('Polska wersja')]
    public function shouldCheckIfPrescriptionIsIssued(bool $checkResult, string $assertSwitch): void
    {
        // Given
        $repository = $this->getMockBuilder(MedicineRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository
            ->expects(self::once())
            ->method('check')
            ->willReturn($checkResult);
        if ($assertSwitch === 'exception') {
            $this->expectException(RuntimeException::class);
        }

        $patient = new Patient();
        $physician = new Physician();
        $dosages = [
            new Dosage(MedicineId::new(), '', 1, 10)
        ];

        // when
        $response = Prescription::issue(
            $repository,
            $patient,
            $physician,
            ...$dosages
        );

        // then
        if ($assertSwitch === 'assert') {
            self::assertNotNull($response);
        }
    }


    #[Test]
    public function shouldHandleEmptyDosage(): void
    {
        // Given
        $repository = $this->getMockBuilder(MedicineRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository
            ->expects(self::atLeastOnce())
            ->method('check')
            ->willReturn(true);

        $this->expectException(EmptyDosageException::class);

        $patient = new Patient();
        $physician = new Physician();
        $dosages = [];

        // when
        $response = Prescription::issue(
            $repository,
            $patient,
            $physician,
            ...$dosages
        );
    }
}