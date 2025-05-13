<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #474E68;
            margin: 0;
            padding: 0;
        }

        header {
            background: #404258;
            color: white;
            text-align: center;
            padding: 40px 10px 25px 10px;
            font-size: 2.2rem;
            box-shadow: 0 4px 16px rgba(62, 180, 137, 0.13);
            border-radius: 0 0 30px 30px;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 30px auto 0 auto;
            padding: 20px;
        }

        .recipe-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(62, 180, 137, 0.08);
            margin: 24px 0;
            padding: 28px 24px 20px 24px;
            transition: transform 0.25s cubic-bezier(.4,2,.6,1), box-shadow 0.25s;
            border-left: 6px solid #3aafa9;
            position: relative;
        }

        .recipe-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 8px 32px rgba(62, 180, 137, 0.16);
        }

        .recipe-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #205072;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recipe-title i {
            color: #4ecca3;
            font-size: 1.3em;
        }

        .recipe-info {
            margin-top: 10px;
            font-size: 1.08rem;
            color: #444;
            line-height: 1.6;
        }

        button[type="submit"], .back button, .dashboard-btn {
            background: linear-gradient(90deg, #3aafa9 0%, #4ecca3 100%);
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(62, 180, 137, 0.13);
            transition: background 0.3s, transform 0.2s;
        }

        button[type="submit"]:hover, .back button:hover, .dashboard-btn:hover {
            background: linear-gradient(90deg, #4ecca3 0%, #3aafa9 100%);
            transform: scale(1.06);
        }

        button[type="submit"]:active, .back button:active, .dashboard-btn:active {
            background: #205072;
            transform: scale(1);
        }

        .error-message {
            color: #e17055;
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }

        .back {
            display: flex;
            justify-content: start;
            margin-left: 0;
            margin-top: 30px;
        }

        .back i {
            margin-right: 7px;
        }

        .dashboard-btn {
            position: absolute;
            top: 24px;
            left: 24px;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 600px) {
            .container {
                width: 98%;
                padding: 8px;
            }
            .recipe-card {
                padding: 16px 8px 12px 12px;
            }
            .dashboard-btn {
                top: 10px;
                left: 10px;
                padding: 8px 14px;
            }
        }
    </style>
</head>
<body >
    <header style=" text-align:center; padding: 24px 0; border-radius:0 0 12px 12px;">
        <h1 style="font-family: 'Arial Black', Arial, sans-serif; font-size:2rem; margin:0; color:#dae1ed;">
            <i class="fa fa-book-open"></i> Daftar Resep
        </h1>
        <div style="font-size:1rem; color:#c4c8cfI. ;">Kumpulan resep favorit, simpel & lezat</div>
    </header>

    <main style="max-width:600px; margin:32px auto; padding:0 12px;">
        @if(session('error'))
            <div style="background:#ffe0e0; color:#c0392b; padding:10px 16px; border-radius:6px; margin-bottom:18px; text-align:center;">
                {{ session('error') }}
            </div>
        @endif

        @if(!empty($recipes))
            @foreach($recipes as $recipe)
                <section style="background:#fffbe7; border:1px solid #ffe29a; border-radius:10px; margin-bottom:22px; box-shadow:0 2px 8px #ffe29a33;">
                    <div style="padding:18px 16px;">
                        <div style="font-weight:bold; font-size:1.15rem; color:#e17009; margin-bottom:8px;">
                            <i class="fa fa-star"></i> {{ $recipe['title'] ?? 'Resep' }}
                        </div>
                        <div style="color:#444; font-size:1rem; line-height:1.6; margin-bottom:10px;">
                            {!! nl2br(e($recipe['recipe'])) !!}
                        </div>
                        <form action="{{ route('recipes.delete', $recipe['id']) }}" method="POST" style="margin-top:10px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:#e17009; color:#fff; border:none; border-radius:5px; padding:7px 18px; cursor:pointer;">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </section>
            @endforeach
        @else
            <div style="text-align:center; color:#888; margin:40px 0;">
                <i class="fa fa-exclamation-circle"></i> Belum ada resep yang tersedia.
            </div>
        @endif

        <div style="display:flex; justify-content:space-between; margin-top:32px;">
            <a href="/dashboard" style="text-decoration:none;">
                <button style="background:#f7b731; color:#222; border:none; border-radius:5px; padding:8px 18px; font-weight:bold; cursor:pointer;">
                    <i class="fa fa-home"></i> Dashboard
                </button>
            </a>
            <a href="/foods" style="text-decoration:none;">
                <button style="background:#f7b731; color:#222; border:none; border-radius:5px; padding:8px 18px; font-weight:bold; cursor:pointer;">
                    <i class="fa fa-arrow-left"></i> Kembali ke Foods
                </button>
            </a>
        </div>
    </main>
</body>
</html>
