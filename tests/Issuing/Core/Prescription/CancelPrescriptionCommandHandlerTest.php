<?php

declare(strict_types=1);

namespace Freyr\Prescription\Tests\Issuing\Core\Prescription;

use Freyr\Prescription\Issuing\Application\FakeCancelPrescription;
use Freyr\Prescription\Issuing\Core\CancelPrescriptionCommandHandler;
use Freyr\Prescription\Issuing\Core\Medicine\Dosage;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineId;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineRepository;
use Freyr\Prescription\Issuing\Core\Patient\Patient;
use Freyr\Prescription\Issuing\Core\Patient\PatientId;
use Freyr\Prescription\Issuing\Core\Physician\Physician;
use Freyr\Prescription\Issuing\Core\Physician\PhysicianId;
use Freyr\Prescription\Issuing\Core\Prescription\Prescription;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionCanceled;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionStatus;
use Freyr\Prescription\Issuing\Infrastructure\PrescriptionInMemoryRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CancelPrescriptionCommandHandlerTest extends TestCase
{

    public function shouldOrchestrateTheProcess(): void
    {

    }

    #[Test]
    public function shouldCancelPrescription(): void
    {
        $medicineRepository = $this->getMockBuilder(MedicineRepository::class)->getMock();
        $medicineRepository->expects($this->once())->method('check')->willReturn(true);
        $prescriptionRepository = new PrescriptionInMemoryRepository();
        $patient = new Patient(PatientId::new());
        $physician = new Physician(PhysicianId::new());
        $dosages = [
            new Dosage(MedicineId::new(), '', 1, 10)
        ];

        // when
        $prescription = Prescription::issue(
            $medicineRepository,
            $patient,
            $physician,
            ...$dosages
        );
        $prescriptionRepository->persist($prescription);
        $commandHandler = new CancelPrescriptionCommandHandler(
            $prescriptionRepository,
        );
        $command = new FakeCancelPrescription($prescription->id, $physician);

        // when
        $commandHandler($command);

        // then
        $prescription = current($prescriptionRepository->prescriptions);
        self::assertInstanceOf(Prescription::class, $prescription);
        $event = current($prescriptionRepository->events);
        self::assertInstanceOf(PrescriptionCanceled::class, $event);
        self::assertEquals(
            PrescriptionStatus::CANCELLED,
            PrescriptionStatus::from($event->field('status'))
        );
    }
}