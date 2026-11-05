<?php

namespace App\Http\Controllers;

use App\Models\RaffleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('settings.edit', ['setting' => RaffleSetting::firstOrCreate(['id' => 1], [
            'store_name' => 'Portátiles Perú',
            'minimum_purchase' => 50,
            'prize' => 'Canasta navideña',
            'draw_date' => now()->setDate(2026, 12, 24),
            'accent_color' => '#0b3882',
            'show_draw_date' => true,
            'date_replacement' => null,
        ])]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:120',
            'minimum_purchase' => 'required|numeric|min:0|max:999999',
            'prize' => 'required|string|max:160',
            'draw_date' => 'required|date',
            'accent_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'show_draw_date' => 'nullable|boolean',
            'date_replacement' => 'nullable|string|max:160',
            'font_family' => 'nullable|in:Arial,Georgia,Verdana,Trebuchet MS',
            'font_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'font_size' => 'nullable|in:normal,large,small',
            'ribbon_text' => 'nullable|string|max:100',
            'thanks_text' => 'nullable|string|max:120',
        ]);

        $data['show_draw_date'] = $request->boolean('show_draw_date');
        RaffleSetting::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Configuración guardada correctamente.');
    }

    public function saveAjax(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:120',
            'prize' => 'required|string|max:160',
            'draw_date' => 'required|date',
            'minimum_purchase' => 'required|numeric|min:0|max:999999',
            'accent_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'show_draw_date' => 'nullable|boolean',
            'date_replacement' => 'nullable|string|max:160',
            'font_family' => 'nullable|in:Arial,Georgia,Verdana,Trebuchet MS',
            'font_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'font_size' => 'nullable|in:normal,large,small',
            'ribbon_text' => 'nullable|string|max:100',
            'thanks_text' => 'nullable|string|max:120',
        ]);
        $data['show_draw_date'] = $request->boolean('show_draw_date');
        $setting = RaffleSetting::updateOrCreate(['id' => 1], $data);
        return response()->json(['success' => true, 'message' => 'Diseño guardado correctamente.', 'draw_date' => optional($setting->draw_date)->format('d/m/Y')]);
    }

    public function saveAssets(Request $request)
    {
        $request->validate([
            'type' => 'required|in:logo,prize',
            'image' => 'required|file|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        $image = $request->file('image');
        if (!$image->isValid() || @getimagesize($image->getRealPath()) === false) {
            return response()->json(['message' => 'La imagen no es válida.'], 422);
        }

        $directory = public_path('uploads/design');
        File::ensureDirectoryExists($directory);
        $filename = Str::random(40) . '.' . strtolower($image->extension());
        $image->move($directory, $filename);
        $path = '/uploads/design/' . $filename;
        $setting = RaffleSetting::firstOrCreate(['id' => 1]);
        $setting->update([$request->input('type') === 'logo' ? 'logo_path' : 'prize_image_path' => $path]);

        return response()->json(['success' => true, 'type' => $request->input('type'), 'path' => $path]);
    }
}
