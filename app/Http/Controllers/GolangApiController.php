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
        // Get the token from the session
        $token = Session::get('token');

        // If no token found, redirect to login
        if (!$token) {
            return redirect('/login');
        }

        // Make GET request to the '/user' endpoint with the token
        $response = Http::withToken($token)->get($this->api.'/users');  // Updated to '/users' endpoint

        // If the response is successful, pass the users data to the view
        if ($response->successful()) {
            $users = $response->json()['users'];  // Get the 'users' array from the response
            return view('user', ['users' => $users]);
        }

        // If something goes wrong, return with an error message
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

        $response = Http::withToken($token)->delete($this->apitest.'/recipes/'.$id);

        if ($response->successful()) {
            return redirect('/recipes');
        }

        return back()->with('error', 'Gagal menghapus resep');
    }

    public function getRecipes()
    {
        $token = Session::get('token');
    
        if (!$token) {
            return redirect('/login');
        }
    
        $response = Http::withToken($token)->get($this->apitest.'/recipes');
    
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
