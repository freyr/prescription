<?php

declare(strict_types=1);

namespace Freyr\Prescription\Tests\Issuing\Core\Prescription;

use Freyr\Prescription\Issuing\Application\FakePrescriptionIssue;
use Freyr\Prescription\Issuing\Core\IssuePrescriptionCommandHandler;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineRepository;
use Freyr\Prescription\Issuing\Core\Patient\PatientRepository;
use Freyr\Prescription\Issuing\Core\Physician\Physician;
use Freyr\Prescription\Issuing\Core\Physician\PhysicianId;
use Freyr\Prescription\Issuing\Core\Physician\PhysicianRepository;
use Freyr\Prescription\Issuing\Core\Prescription\Prescription;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionIssued;
use Freyr\Prescription\Issuing\Infrastructure\PrescriptionInMemoryRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class IssuePrescriptionCommandHandlerTest extends TestCase
{

    public function shouldOrchestrateTheProcess(): void
    {

    }

    #[Test]
    public function shouldIssueNewPrescription(): void
    {
        $patientRepository = $this->getMockBuilder(PatientRepository::class)->getMock();
        $physicianRepository = $this->getMockBuilder(PhysicianRepository::class)->getMock();;
        $physicianRepository->expects($this->once())->method('getById')->willReturn(new Physician(PhysicianId::new()));
        $medicineRepository = $this->getMockBuilder(MedicineRepository::class)->getMock();
        $medicineRepository->expects($this->once())->method('check')->willReturn(true);
        $prescriptionRepository = new PrescriptionInMemoryRepository();
        $commandHandler = new IssuePrescriptionCommandHandler(
            $patientRepository,
            $medicineRepository,
            $prescriptionRepository,
            $physicianRepository
        );
        $command = new FakePrescriptionIssue();

        // when
        $commandHandler($command);

        // then
        self::assertNotEmpty($prescriptionRepository->prescriptions);
        $prescription = current($prescriptionRepository->prescriptions);
        self::assertInstanceOf(Prescription::class, $prescription);
        $event = current($prescriptionRepository->events);
        self::assertInstanceOf(PrescriptionIssued::class, $event);
    }
}