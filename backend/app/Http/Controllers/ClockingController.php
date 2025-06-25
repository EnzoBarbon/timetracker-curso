<?php

namespace App\Http\Controllers;

use App\Models\ClockingDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClockingController extends Controller
{
    public function clockIn(Request $request, $date)
    {
        // Validar autenticación
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validar formato de fecha
        $validator = Validator::make(['date' => $date], [
            'date' => 'required|date_format:Y-m-d'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
        }

        // Verificar si ya existe un clock-in para este usuario y fecha
        $existingRecord = ClockingDay::where('user_id', $user->id)
            ->where('date', $date)
            ->first();

        if ($existingRecord && $existingRecord->check_in) {
            return response()->json(['error' => 'Already clocked in for this date'], 409);
        }

        try {
            // Crear o actualizar registro de clock-in
            $clockingDay = ClockingDay::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'date' => $date,
                ],
                [
                    'check_in' => Carbon::now()->format('H:i:s'),
                ]
            );

            return response()->json([
                'message' => 'Successfully clocked in',
                'data' => [
                    'id' => $clockingDay->id,
                    'user_id' => $clockingDay->user_id,
                    'date' => $clockingDay->date,
                    'check_in' => $clockingDay->check_in,
                    'check_out' => $clockingDay->check_out,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error creating clock-in record',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function clockOut(Request $request, $date)
    {
        // Validar autenticación
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validar formato de fecha
        $validator = Validator::make(['date' => $date], [
            'date' => 'required|date_format:Y-m-d'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
        }

        // Buscar el registro de clock-in para este usuario y fecha
        $clockingDay = ClockingDay::where('user_id', $user->id)
            ->where('date', $date)
            ->first();

        // Verificar que existe un clock-in previo
        if (!$clockingDay || !$clockingDay->check_in) {
            return response()->json(['error' => 'No clock-in found for this date. Please clock in first.'], 404);
        }

        // Verificar si ya existe un clock-out
        if ($clockingDay->check_out) {
            return response()->json(['error' => 'Already clocked out for this date'], 409);
        }

        try {
            // Actualizar registro con clock-out
            $clockingDay->update([
                'check_out' => Carbon::now()->format('H:i:s'),
            ]);

            return response()->json([
                'message' => 'Successfully clocked out',
                'data' => [
                    'id' => $clockingDay->id,
                    'user_id' => $clockingDay->user_id,
                    'date' => $clockingDay->date,
                    'check_in' => $clockingDay->check_in,
                    'check_out' => $clockingDay->check_out,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating clock-out record',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function coffeeBreakIn(Request $request, $date)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $validator = Validator::make(['date' => $date], [
            'date' => 'required|date_format:Y-m-d'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
        }
        $clockingDay = ClockingDay::where('user_id', $user->id)
            ->where('date', $date)
            ->first();
        if (!$clockingDay || !$clockingDay->check_in) {
            return response()->json(['error' => 'No clock-in found for this date. Please clock in first.'], 404);
        }
        if ($clockingDay->coffee_break_in) {
            return response()->json(['error' => 'Already registered coffee break in for this date'], 409);
        }
        try {
            $clockingDay->update([
                'coffee_break_in' => Carbon::now()->format('H:i:s'),
            ]);
            return response()->json([
                'message' => 'Successfully registered coffee break in',
                'data' => [
                    'id' => $clockingDay->id,
                    'user_id' => $clockingDay->user_id,
                    'date' => $clockingDay->date,
                    'coffee_break_in' => $clockingDay->coffee_break_in,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating coffee break in',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function coffeeBreakOut(Request $request, $date)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $validator = Validator::make(['date' => $date], [
            'date' => 'required|date_format:Y-m-d'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
        }
        $clockingDay = ClockingDay::where('user_id', $user->id)
            ->where('date', $date)
            ->first();
        if (!$clockingDay || !$clockingDay->coffee_break_in) {
            return response()->json(['error' => 'No coffee break in found for this date. Please register coffee break in first.'], 404);
        }
        if ($clockingDay->coffee_break_out) {
            return response()->json(['error' => 'Already registered coffee break out for this date'], 409);
        }
        try {
            $clockingDay->update([
                'coffee_break_out' => Carbon::now()->format('H:i:s'),
            ]);
            return response()->json([
                'message' => 'Successfully registered coffee break out',
                'data' => [
                    'id' => $clockingDay->id,
                    'user_id' => $clockingDay->user_id,
                    'date' => $clockingDay->date,
                    'coffee_break_out' => $clockingDay->coffee_break_out,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating coffee break out',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function lunchBreakIn(Request $request, $date)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $validator = Validator::make(['date' => $date], [
            'date' => 'required|date_format:Y-m-d'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
        }
        $clockingDay = ClockingDay::where('user_id', $user->id)
            ->where('date', $date)
            ->first();
        if (!$clockingDay || !$clockingDay->check_in) {
            return response()->json(['error' => 'No clock-in found for this date. Please clock in first.'], 404);
        }
        if ($clockingDay->lunch_break_in) {
            return response()->json(['error' => 'Already registered lunch break in for this date'], 409);
        }
        try {
            $clockingDay->update([
                'lunch_break_in' => Carbon::now()->format('H:i:s'),
            ]);
            return response()->json([
                'message' => 'Successfully registered lunch break in',
                'data' => [
                    'id' => $clockingDay->id,
                    'user_id' => $clockingDay->user_id,
                    'date' => $clockingDay->date,
                    'lunch_break_in' => $clockingDay->lunch_break_in,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating lunch break in',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function lunchBreakOut(Request $request, $date)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $validator = Validator::make(['date' => $date], [
            'date' => 'required|date_format:Y-m-d'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
        }
        $clockingDay = ClockingDay::where('user_id', $user->id)
            ->where('date', $date)
            ->first();
        if (!$clockingDay || !$clockingDay->lunch_break_in) {
            return response()->json(['error' => 'No lunch break in found for this date. Please register lunch break in first.'], 404);
        }
        if ($clockingDay->lunch_break_out) {
            return response()->json(['error' => 'Already registered lunch break out for this date'], 409);
        }
        try {
            $clockingDay->update([
                'lunch_break_out' => Carbon::now()->format('H:i:s'),
            ]);
            return response()->json([
                'message' => 'Successfully registered lunch break out',
                'data' => [
                    'id' => $clockingDay->id,
                    'user_id' => $clockingDay->user_id,
                    'date' => $clockingDay->date,
                    'lunch_break_out' => $clockingDay->lunch_break_out,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating lunch break out',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
