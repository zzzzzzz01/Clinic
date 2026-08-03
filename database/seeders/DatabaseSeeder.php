<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class, 
            UserSeeder::class,
            DepartmentSeeder::class,
            // Room
            FeatureSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            BedRoomSeeder::class,
            DepartmentFeatureSeeder::class,
            DepartmentDiseaseSeeder::class,
            DoctorSeeder::class,
            NurseSeeder::class,
            DepartmentDoctorSeeder::class,
            DaySeeder::class,
            PatientSeeder::class,
            StaffScheduleSeeder::class,
            HistoricalAppointmentSlotSeeder::class,
            AppointmentSlotSeeder::class,
            HistoricalAppointmentSeeder::class,
            AppointmentSeeder::class,
            HistoricalHospitalizationSeeder::class,
            HospitalizationSeeder::class,
            HistoricalHospitalizationRoomSeeder::class, 
            SupplierSeeder::class,
            CategoryMedicineSeeder::class,
            MedicineSeeder::class,
            MedicineStockSeeder::class,
            MedicineUsagesSeeder::class,

            FeatureRoomSeeder::class,
            TestSeeder::class,
            // PanelSeeder::class,
            // PanelTestSeeder::class,
            ProcedureSeeder::class,
            HospitalizationRoomSeeder::class,
            HistoricalHospitalizationStaffSeeder::class,
            HospitalizationStaffSeeder::class,
            HistoricalHospitalizationPrescriptionSeeder::class,
            HistoricalHospitalizationProcedureSeeder::class,
            HospitalizationProcedureSeeder::class,
            HospitalizationPrescriptionSeeder::class,
            HospitalizationPrescriptionItemSeeder::class,
            HospitalizationPrescriptionItemSlotSeeder::class,
            HospitalizationPrescriptionAdministrationSeeder::class,
            HistoricalHospitalizationOrderSeeder::class,
            HospitalizationOrderSeeder::class,
            HospitalizationOrderItemSeeder::class,
            TestResultSeeder::class,
            FaqSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,

        ]);
    }
}
