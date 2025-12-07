<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function list($pet_id)
    {
        $search = request('search');
        $reminders = Reminder::with(['user'])
            ->where('pet_id', $pet_id)
            ->where(function($query) use ($search) {
                if ($search) {
                    $query->where('description', 'like', "%$search%")
                          ->orWhere('date', 'like', "%$search%");
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(5);
        return view('administrations.reminders.reminder-list', compact('reminders'));
    }

    public function store(Request $request)
    {
        try {
            Reminder::create([
                'pet_id' => $request->pet_id,
                'user_id' => Auth::id(),
                'date' => $request->date,
                'time' => $request->time,
                'description' => $request->description,
            ]);
            return response()->json(['success' => true, 'message' => 'Recordatorio guardado exitosamente.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al guardar el recordatorio.']);
        }
    }

    public function destroy(Reminder $reminder)
    {
        try {
            $reminder->delete();
            return response()->json(['success' => true, 'message' => 'Recordatorio eliminado exitosamente.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al eliminar el recordatorio.']);
        }
    }
}
