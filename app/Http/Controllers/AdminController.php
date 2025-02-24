<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\TourDetail;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Показать список туров
    public function adminIndex()
    {
        $tours = Tour::all();
        return view('admin.adminIndex', compact('tours'));
    }

    // Сохранить новый тур
    public function Adminstore(Request $request)
    {
        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'available_dates' => 'required|array',
            'available_dates.*' => 'date',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // валидация для изображения
        ]);

        // Создание объекта тур
        $tourData = $request->except('image_url'); // Получаем все данные из запроса, исключая image_url

        // Обработка загрузки изображения
        if ($request->hasFile('image_url')) {
            // Генерация уникального имени файла
            $filename = time() . '.' . $request->file('image_url')->extension();

            // Сохранение файла в папку public/photo
            $request->file('image_url')->move(public_path('photo'), $filename);

            // Добавление пути к изображению
            $tourData['image_url'] = 'photo/' . $filename; // путь к изображению
        }

        // Сохраняем тур
        Tour::create($tourData);

        return redirect()->route('adminIndex')->with('success', 'Тур добавлен успешно!');
    }




    // Удалить тур
    public function destroy(Tour $tour)
    {
        $tour->delete();

        return redirect()->route('adminIndex')->with('success', 'Тур удален!');
    }

    public function AdminApp()
    {
        $bookings = Booking::all();
        return view('admin.AdminApp', compact('bookings'));
    }

    public function changeStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Убедимся, что передан статус
        if ($request->has('status')) {
            $newStatus = $request->input('status');

            // Убедимся, что переданное значение допустимо
            if (in_array($newStatus, ['confirmed', 'canceled'])) {
                $booking->status = $newStatus;
                $booking->save();

                return redirect()->route('AdminApp')->with('success', 'Статус бронирования изменен.');
            }
        }

        return redirect()->route('AdminApp')->with('error', 'Ошибка изменения статуса.');
    }


    public function adminUpdate_show($id)
    {
        $tour = Tour::findOrFail($id);
        // Загружаем связанные детали тура
        // $tourDetails = TourDetail::where('tour_id', $id)->get();

        return view('admin.adminUpdate', compact('tour'));
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);
        $tour->update($request->all());

        // Обработка изображения
        if ($request->hasFile('image_url')) {
            // Генерация уникального имени файла
            $filename = time() . '.' . $request->file('image_url')->extension();

            // Сохранение файла в папку public/photo
            $request->file('image_url')->move(public_path('photo'), $filename);

            // Добавление пути к изображению в базу данных
            $tour->image_url = '/photo/' . $filename;  // Путь будет /photo/photo2.jpg
            $tour->save();
        }

        return redirect()->route('adminIndex')->with('success', 'Тур обновлен!');
    }
}
