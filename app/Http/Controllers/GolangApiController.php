<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GolangApiController extends Controller
{
    private $api = 'https://golang-production-c9c3.up.railway.app';

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $r)
    {
        $data = [
            'username' => $r->username,
            'password' => $r->password,
            'role' => 'user',
        ];

        $response = Http::post($this->api.'/register', $data);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Berhasil daftar');
        } else {
            return back()->with('error', 'Gagal daftar: ' . $response->json()['error']);
        }
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $r)
    {
        $response = Http::post($this->api.'/login', $r->all());
        $responseData = $response->json();

        \Log::info('Login API Response: ', ['response' => $responseData]);

        if ($response->successful() && isset($responseData['token'])) {
            Session::put('token', $responseData['token']);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Login gagal: ' . ($responseData['error'] ?? 'Unknown error'));
    }

    public function dashboard()
    {
        return view('dashboard');  
    }

    public function getFoods()
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/foods');

        \Log::info('API Response for Foods: ', ['response' => $response->json()]);

        $foods = $response->successful() ? $response->json() : [];

        if (!is_array($foods)) {
            $foods = [];
        }

        return view('foods', ['foods' => $foods]);
    }

    public function addFood(Request $r)
{
    $token = Session::get('token');

    if (!$token) {
        return redirect('/login');
    }

    $response = Http::withToken($token)->post($this->api.'/foods', [
        'name' => $r->name,
        'expiry_date' => $r->expiry_date
    ]);

    if ($response->successful()) {
        return redirect('/foods');
    }


    return back()->with('error', 'Gagal menambah makanan');
}



    public function deleteFood($id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->delete($this->api.'/foods/'.$id);

        if ($response->successful()) {
            return redirect('/foods');
        }

        return back()->with('error', 'Gagal menghapus makanan');
    }

    public function getRecipes()
{
    $token = Session::get('token');

    if (!$token) {
        return redirect('/login');
    }

    $response = Http::withToken($token)->get($this->api.'/recipes');

    if ($response->successful()) {
        $recipes = $response->json()['recipes'] ?? [];

        if (empty($recipes)) {
            return back()->with('error', 'Tidak ada resep yang ditemukan.');
        }

        return view('recipes', ['recipes' => $recipes]);
    }

    return back()->with('error', 'Gagal mengambil resep');
}


    public function addRecipe(Request $r)
    {
        $token = Session::get('token');
   


        if (!$token) {
            return response()->json(['error' => 'Token tidak valid'], 401);
        }

        $foodId = $r->food_id;
        if (empty($foodId) || !is_numeric($foodId) || $foodId <= 0) {
            return response()->json(['error' => 'food_id tidak valid'], 400);
        }

        try {
            $response = Http::withToken($token)->post($this->api.'/recipe', [
                'food_id' => $foodId
            ]);

       

            if ($response->successful()) {
                $recipe = $response->json()['recipe'] ?? null;

                if ($recipe) {
                    return response()->json(['recipe' => $recipe], 200);
                } else {
                    return response()->json(['error' => 'Resep tidak ditemukan'], 404);
                }
            } else {
                return response()->json(['error' => 'Gagal menghubungi API untuk menghasilkan resep', 'details' => $response->json()], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan pada server', 'message' => $e->getMessage()], 500);
        }
    }
}
