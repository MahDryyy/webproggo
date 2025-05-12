<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GolangApiController extends Controller
{
    private $api = 'https://golang-production-c9c3.up.railway.app';

    private $apitest = 'http://localhost:8080';

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $r)
    {
        $data = [
            'username' => $r->username,
            'password' => $r->password,
            'email' => $r->email,
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
        $role = $responseData['role'] ?? null;

        Session::put('token', $responseData['token']);
        Session::put('role', $role);

        \Log::info('Role yang diterima:', ['role' => $role]);

        if ($role === 'admin') {
            return redirect('/admin-dashboard');
        }else{
            return redirect('/dashboard');
        }

        
    }

    return back()->with('error', 'Login gagal: ' . ($responseData['error'] ?? 'Unknown error'));
}

    public function adminDashboard()
{
    return view('admin-dashboard'); 
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
        return response()->json($foods);
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
    public function getUser()
    {
     
        $token = Session::get('token');

      
        if (!$token) {
            return redirect('/login');
        }

        
        $response = Http::withToken($token)->get($this->api.'/users');  

        
        if ($response->successful()) {
            $users = $response->json()['users'];  
            return view('user', ['users' => $users]);
        }

       
        return back()->with('error', 'Gagal mengambil data users');
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

   public function deleteRecipe($id)
{

    $token = Session::get('token');

    
    if (!$token) {
        return redirect('/login');
    }

   
    $response = Http::withToken($token)->delete($this->api . '/recipes/' . $id);

    
    if ($response->successful()) {
        return redirect('/recipes');
    }

    
    return back()->with('error', 'Gagal menghapus resep');
}

    public function getLoginLogs()
{
    $token = Session::get('token');

    if (!$token) {
        return redirect('/login');
    }

    $response = Http::withToken($token)->get($this->api . '/login-logs');

    if ($response->successful()) {
        $loginLogs = $response->json()['login_logs'] ?? [];

        if (empty($loginLogs)) {
            return view('loginlogs.index', ['loginLogs' => [], 'message' => 'Tidak ada login logs ditemukan.']);
        }

        return view('loginlogs', ['loginLogs' => $loginLogs]);
    }

    return back()->with('error', 'Gagal mengambil login logs');
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
                
                return view('recipes', ['recipes' => [], 'message' => 'Tidak ada resep yang ditemukan.']);
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

    // Mengambil food_id yang bisa berupa array
    $foodIds = $r->food_id;

    // Pastikan food_id adalah array dan setiap item di dalamnya adalah angka positif
    if (empty($foodIds) || !is_array($foodIds) || !collect($foodIds)->every(fn($id) => is_numeric($id) && $id > 0)) {
        return response()->json(['error' => 'food_id tidak valid'], 400);
    }

    try {
        // Kirimkan food_id sebagai array ke API Go
        $response = Http::withToken($token)->post($this->apitest.'/recipe', [
            'food_id' => $foodIds // Mengirimkan array food_id
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
