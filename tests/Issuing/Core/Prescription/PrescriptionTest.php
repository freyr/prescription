<?php

declare(strict_types=1);

namespace Freyr\Prescription\Tests\Issuing\Core\Prescription;

use Freyr\Prescription\Issuing\Core\Medicine\Dosage;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineId;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineRepository;
use Freyr\Prescription\Issuing\Core\Patient\Patient;
use Freyr\Prescription\Issuing\Core\Physician\Physician;
use Freyr\Prescription\Issuing\Core\Prescription\Prescription;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PrescriptionTest extends TestCase
{

    #[test]
    public function shouldCheckIfPrescriptionIsIssued(): void
    {
        // Given
        $repository = $this->getMockBuilder(MedicineRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository
            ->expects(self::once())
            ->method('check')
            ->willReturn(true);

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
        self::assertNotNull($response);


    }
}