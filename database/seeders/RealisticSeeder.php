<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\BimbelJournal;
use App\Models\ClassLevel;
use App\Models\Material;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentReport;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RealisticSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // 1. Get Core Data
            $tutor = User::where('email', 'tutor@rumbaathaya.com')->first();

            if (!$tutor) {
                $this->command->error('Tutor user not found. Please run DatabaseSeeder first.');
                return;
            }

            // Ensure Class Levels exist first (StudentSeeder depends on them)
            // Always run ClassLevelSeeder because it uses updateOrCreate, preventing missing data issues
            $this->call(ClassLevelSeeder::class);

            // Ensure Subjects exist
            $subjects = Subject::all();
            if ($subjects->isEmpty()) {
                $this->command->warn('No subjects found. Running SubjectSeeder...');
                $this->call(SubjectSeeder::class);
                $subjects = Subject::all();
            }

            $students = Student::all();
            if ($students->count() < 5) {
                $this->command->warn('Not enough students found. Running StudentSeeder...');
                $this->call(StudentSeeder::class);
                $students = Student::all();
            }

            // 2. Clear Operational Data related to this tutor to prevent duplication on multiple runs
            // Be careful in production, but okay for dev seeding
            $this->command->info('Cleaning up old operational data for tutor...');
            Attendance::where('tutor_id', $tutor->id)->delete();
            Schedule::where('tutor_id', $tutor->id)->delete();
            Material::where('uploaded_by', $tutor->id)->delete();
            BimbelJournal::where('tutor_id', $tutor->id)->delete();

            // 3. Create Materials
            $this->command->info('Creating Materials...');
            $subjects = Subject::all();
            $count = $subjects->count();
            // Take up to 5 subjects, or all if less than 5
            $materialSubjects = $count >= 5 ? $subjects->random(5) : $subjects;

            foreach ($materialSubjects as $subject) {
                Material::create([
                    'title' => 'Modul Belajar ' . $subject->name . ' - Bab ' . rand(1, 5),
                    'description' => 'Materi pembelajaran lengkap untuk ' . $subject->name . ' tingkat dasar dan menengah. Mencakup teori dan latihan soal.',
                    'file_path' => null, // Or a dummy path if needed
                    'subject_id' => $subject->id,
                    'class_level_id' => ClassLevel::inRandomOrder()->first()->id ?? null,
                    'uploaded_by' => $tutor->id,
                    'tutor_id' => $tutor->id,
                ]);
            }

            // 4. Create Schedules & Attendances
            $this->command->info('Creating Schedules and Attendance History...');

            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $todayStr = now()->format('l'); // e.g. "Tuesday"

            // We want ensure we have schedules for TODAY
            $schedulesCreated = 0;

            foreach ($students as $index => $student) {
                // Assign 2-3 subjects per student
                $studentSubjects = $subjects->random(rand(1, 2));

                foreach ($studentSubjects as $subject) {
                    // Determine day of week
                    // If this is one of the first few students, force it to be TODAY so we have data for dashboard
                    if ($schedulesCreated < 3) {
                        $day = $todayStr;
                    } else {
                        $day = $days[array_rand($days)];
                    }

                    // Create Schedule
                    $timeStart = Carbon::createFromTime(rand(13, 17), 00); // 1 PM to 5 PM
                    $timeEnd = $timeStart->copy()->addMinutes(90);

                    $schedule = Schedule::create([
                        'tutor_id' => $tutor->id,
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'day_of_week' => $day,
                        'time_start' => $timeStart->format('H:i'),
                        'time_end' => $timeEnd->format('H:i'),
                        'is_active' => true,
                    ]);

                    $schedulesCreated++;

                    // 5. Generate Past Attendance (Backfill 4 weeks)
                    // Find all dates for this $day in the past 30 days
                    $currentDate = now()->copy();

                    // If the schedule is for TODAY, handle separately

                    for ($i = 0; $i < 4; $i++) {
                        // Try to find the date for this day of week going backwards
                        // logic: find previous occurrence of $day
                        $date = new Carbon("last $day");
                        $date->subWeeks($i);

                        if ($date->gt(now()))
                            continue; // Should not happen with "last" logic but safety check

                        // Random status
                        $rand = rand(1, 10);
                        if ($rand <= 8)
                            $status = 'present';
                        elseif ($rand == 9)
                            $status = 'permission';
                        else
                            $status = 'absent';

                        Attendance::create([
                            'schedule_id' => $schedule->id,
                            'tutor_id' => $tutor->id,
                            'student_id' => $student->id,
                            'date' => $date->format('Y-m-d'),
                            'topic_taught' => "Materi Bab " . ($i + 1) . ": Pengenalan " . $subject->name,
                            'student_progress_note' => $status == 'present' ? "Siswa memahami materi dengan baik." : null,
                            'status' => $status,
                        ]);

                        // Create Journal for this attendance if present
                        if ($status == 'present') {
                            BimbelJournal::create([
                                'tutor_id' => $tutor->id,
                                'schedule_id' => $schedule->id,
                                'date' => $date->format('Y-m-d'),
                                'time' => $timeStart->format('H:i'),
                                'material' => "Materi Bab " . ($i + 1),
                                'documentation_path' => null,
                            ]);
                        }
                    }

                    // 6. Handle TODAY'S Attendance
                    // If schedule day IS today, create an attendance record (maybe empty/pending, or already filled)
                    if ($day === $todayStr) {
                        // 50% chance we already took attendance today
                        if (rand(0, 1)) {
                            Attendance::create([
                                'schedule_id' => $schedule->id,
                                'tutor_id' => $tutor->id,
                                'student_id' => $student->id,
                                'date' => now()->format('Y-m-d'),
                                'topic_taught' => "Materi Bab 5: Latihan Soal",
                                'student_progress_note' => "Sedang mengerjakan latihan.",
                                'status' => 'present',
                            ]);
                        }
                        // Else: No attendance record yet (Dashboard will usually show it as "Not Taken" if logic exists, or just empty list)
                        // The dashboard typically fetches schedules and matches with attendance.
                    }
                }
            }

            // 7. Create Student Reports (Randomly)
            $this->command->info('Creating Student Reports...');
            foreach ($students as $student) {
                if (rand(0, 1))
                    continue; // Only for some students

                StudentReport::create([
                    'student_id' => $student->id,
                    'subject_id' => $subjects->random()->id,
                    'score' => rand(60, 100),
                    'attendance_count' => rand(10, 12),
                    'notes' => 'Perkembangan siswa sangat baik, perlu ditingkatkan ketelitiannya.',
                    'period' => 'Desember 2025',
                    'report_date' => now()->subDays(rand(1, 10)),
                ]);
            }

            $this->command->info('Realistic Data Seeding Completed!');
            $this->command->info('Total Schedules: ' . $schedulesCreated);
        } catch (\Exception $e) {
            $this->command->error('Seeder Failed: ' . $e->getMessage());
            $this->command->error('Trace: ' . $e->getTraceAsString());
        }
    }
}
