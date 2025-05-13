<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use carbon\carbon;

class GolangApiController extends Controller
{
    private $api = 'https://golang-production-c9c3.up.railway.app';

    private $apitest = 'http://localhost:8080'; 

    public function showRegisterForm()
    {
        return view('register');
    }

    public function activityLogs()
    {
        $token = Session::get('token');
        
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api . '/login-logs');

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil login logs');
        }

        $loginLogs = $response->json()['login_logs'] ?? [];

        $dates = [];
        $logins = [];
        $failedLogins = 0;

        $responseUsers = Http::withToken($token)->get($this->api . '/users');
        
        $userCount = 0;
        if ($responseUsers->successful()) {
            $users = $responseUsers->json()['users'] ?? [];
            $userCount = count($users);
        }

        foreach ($loginLogs as $log) {
            $date = \Carbon\Carbon::parse($log['LoginTime'])->format('l');
            if (!isset($dates[$date])) {
                $dates[$date] = 0;
            }
            $dates[$date]++;

            if (isset($log['status']) && $log['status'] == 'failed') {
                $failedLogins++;
            }
        }

        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $sortedLogins = [];
        foreach ($daysOfWeek as $day) {
            $sortedLogins[] = $dates[$day] ?? 0;
        }

        $todayLogins = 0;
        $todayDate = \Carbon\Carbon::today()->toDateString();
        foreach ($loginLogs as $log) {
            if (\Carbon\Carbon::parse($log['LoginTime'])->toDateString() == $todayDate) {
                $todayLogins++;
            }
        }

        return view('admin-dashboard', [
            'loginActivity' => [
                'dates' => $daysOfWeek,
                'logins' => $sortedLogins,
            ],
            'userCount' => $userCount, 
            'todayLogins' => $todayLogins,
            'failedLogins' => $failedLogins,
        ]);
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
            } else {
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
    $token = Session::get('token');
    if (!$token) return redirect('/login');

    $response = Http::withToken($token)->get($this->api.'/foods');
    $foods = $response->successful() ? $response->json() : [];

    return view('dashboard', ['foods' =>$foods]);
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

        $foods = collect($foods)->map(function ($food) {
            $expiry = Carbon::parse($food['expiry_date']);
            $today = Carbon::today();
            $expiryDate = $food['expiry_date'];
            $diffInDays = $today->diffInDays($expiryDate, false);

            if($diffInDays < 0){
                $food['status'] = 'expired';
                $food['color'] ='red';
                $food['icon'] = '❌';

            }elseif($diffInDays < 3){
                $food['status'] = 'warning';
                $food['color'] ='orange';
                $food['icon'] = '⚠️';
            }else{
                $food['status'] = 'safe';
                $food['color'] ='green';
                $food['icon'] = '✅';
            }

            return $food;
        })
        ->sortBy(function ($food) {
            $iconOrder = ['❌' => 0, '⚠️' => 1, '✅' => 2];
            return $iconOrder[$food['icon']] ?? 3;
        })
        ->values();

        return view('foods', ['foods' => $foods]);

        
    }


    public function getFoodsCalendarApi()
{
    $token = Session::get('token');
    if (!$token) {
        return response()->json([]);
    }

    $response = Http::withToken($token)->get($this->api . '/foods');
    $foods = $response->successful() ? $response->json() : [];

    $now = now();

    $foods = collect($foods)->map(function ($food) use ($now) {
        $expiry = \Carbon\Carbon::parse($food['expiry_date']);
        $diffDays = $expiry->diffInDays($now, false); 

        $food['is_near_expired'] = $diffDays <= 14 && $diffDays >= 0;
        $food['is_expired'] = $diffDays < 0;

        return $food;
    });

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

        $foodIds = $r->food_id;

        if (empty($foodIds) || !is_array($foodIds) || !collect($foodIds)->every(fn($id) => is_numeric($id) && $id > 0)) {
            return response()->json(['error' => 'food_id tidak valid'], 400);
        }

        try {
            $response = Http::withToken($token)->post($this->api.'/recipe', [
                'food_id' => $foodIds
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
