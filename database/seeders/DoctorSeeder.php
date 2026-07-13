<?php

namespace Database\Seeders;

use App\Models\role;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctorRole = role::where('name', 'doctor')->firstOrCreate(['name' => 'doctor']);

        $sampleDoctors = [
            [
                'name' => 'Dr. Sarah Mitchell',
                'email' => 'sarah.mitchell@orthocore.com',
                'specialization' => 'Joint Replacement & Reconstruction',
                'biography' => 'Dr. Mitchell is a fellowship-trained surgeon with over 18 years of experience. She specializes in minimally invasive hip and knee reconstructions.',
                'license_number' => 'DOC-182736',
                'clinic_address' => 'Suite 401, OrthoCore Clinic, NY',
            ],
            [
                'name' => 'Dr. James Okafor',
                'email' => 'james.okafor@orthocore.com',
                'specialization' => 'Sports Medicine & Arthroscopy',
                'biography' => 'Dr. Okafor is the lead sports physician for multiple NY athletic clubs. He specializes in ACL and rotator cuff repairs with fast recovery protocols.',
                'license_number' => 'DOC-928172',
                'clinic_address' => 'Suite 402, OrthoCore Clinic, NY',
            ],
            [
                'name' => 'Dr. Priya Sharma',
                'email' => 'priya.sharma@orthocore.com',
                'specialization' => 'Spine Surgery & Pain Management',
                'biography' => 'Dr. Sharma completed her fellowship at the Mayo Clinic. She has over 20 years of experience treating complex spine and neck conditions.',
                'license_number' => 'DOC-384729',
                'clinic_address' => 'Suite 403, OrthoCore Clinic, NY',
            ],
            [
                'name' => 'Dr. Marcus Vance',
                'email' => 'marcus.vance@orthocore.com',
                'specialization' => 'Fracture & Trauma Care',
                'biography' => 'Dr. Vance specializes in orthopaedic trauma surgery, complex bone fractures, and reconstructive surgery following traumatic injuries.',
                'license_number' => 'DOC-572910',
                'clinic_address' => 'Suite 404, OrthoCore Clinic, NY',
            ]
        ];

        foreach ($sampleDoctors as $docData) {
            // Check if user already exists
            $user = User::where('email', $docData['email'])->first();

            if (!$user) {
                $user = User::create([
                    'name' => $docData['name'],
                    'email' => $docData['email'],
                    'password' => Hash::make('password123'),
                    'Contact_Number' => '555-019' . rand(0, 9),
                    'address' => 'New York, USA',
                ]);
            }

            // Sync doctor role
            if (!$user->hasRole('doctor')) {
                $user->roles()->attach($doctorRole->id);
            }

            // Create Doctor profile
            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization' => $docData['specialization'],
                    'biography' => $docData['biography'],
                    'license_number' => $docData['license_number'],
                    'clinic_address' => $docData['clinic_address'],
                ]
            );
        }
    }
}
