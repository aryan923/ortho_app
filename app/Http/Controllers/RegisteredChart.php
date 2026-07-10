<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RegisteredChart extends Controller
{
    public function getRegisteredChartData()
    {
        $days = 7;
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();

        // Users: users with role 'user' (registered patients)
        $patientData = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name', 'user')
            ->where('users.created_at', '>=', $startDate)
            ->select(DB::raw('DATE(users.created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date');

        // Doctors: users with role 'doctor'
        $doctorData = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name', 'doctor')
            ->where('users.created_at', '>=', $startDate)
            ->select(DB::raw('DATE(users.created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date');

        // Build Google Charts DataTable rows
        $chartData = [['Date', 'Users', 'Doctors']];

        for ($i = $days - 1; $i >= 0; $i--) {
            $dateStr      = Carbon::now()->subDays($i)->format('Y-m-d');
            $formattedDate = Carbon::now()->subDays($i)->format('d M');
            $chartData[] = [
                $formattedDate,
                (int) ($patientData->get($dateStr, 0)),
                (int) ($doctorData->get($dateStr, 0)),
            ];
        }

        return response()->json($chartData);
    }
}
