<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe</title>
</head>
<body>
    <h1>Recipe for Food</h1>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    @if(isset($recipe) && !empty($recipe))
        <h2>{{ $recipe['name'] }}</h2>
        <p>Ingredients: {{ $recipe['ingredients'] }}</p>
        <p>Instructions: {{ $recipe['instructions'] }}</p>
    @else
        <p>No recipe available for this food.</p>
    @endif

    <a href="/foods">Back to Foods</a>
</body>
</html>
