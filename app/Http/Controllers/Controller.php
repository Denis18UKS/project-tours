<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(Request $request)
    {
        $query = Tour::query();

        // Поиск по названию и локации
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('location', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Фильтр по датам
        if ($request->filled('date')) {
            $searchDate = $request->date;
            $query->where(function ($q) use ($searchDate) {
                $q->whereJsonContains('available_dates', $searchDate);
            });
        }

        // Фильтр по длительности
        if ($request->filled('duration_min')) {
            $query->where('duration', '>=', $request->duration_min);
        }
        if ($request->filled('duration_max')) {
            $query->where('duration', '<=', $request->duration_max);
        }

        // Фильтр по цене
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Фильтр по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Сортировка
        switch ($request->input('sort', 'price_asc')) {
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'duration':
                $query->orderBy('duration', 'asc');
                break;
            case 'price_asc':
            default:
                $query->orderBy('price', 'asc');
                break;
        }

        // Пагинация с сохранением параметров фильтрации
        $tours = $query->paginate(12)->withQueryString();

        return view('index', compact('tours'));
    }

    public function tour()
    {
        $tours = Tour::all();

        return response()->view('tour', compact('tours'));
    }
    public function show($id)
    {
        $tour = Tour::findOrFail($id);
        return view('infoTour', compact('tour'));
    }

    public function home()
    {
        $user = auth()->user();
        $bookedTours = $user->bookings()
            ->with('tour') // Загружаем связанные данные тура
            ->latest() // Сортируем по дате создания (новые первыми)
            ->get();

        // Добавим отладочную информацию
        \Log::info('User bookings:', ['count' => $bookedTours->count()]);

        return view('home', compact('user', 'bookedTours'));
    }

    public function store(Request $request, $tourId)
    {

        $validated = $request->validate([
            'seats_booked' => 'required|integer|min:1',
        ]);

        $tour = Tour::findOrFail($tourId);

        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->tour_id = $tour->id;
        $booking->date = $request->booking_date;
        $booking->seats_booked = $request->seats_booked;
        $booking->status = 'pending';
        $booking->save();

        return redirect()->route('home')->with('success', 'Ваше бронирование успешно!');
    }
}
