# Laravel CRUD Generator

[![Latest Stable Version](https://poser.pugx.org/webvelopers/laravel-crud-generator/v)](//packagist.org/packages/webvelopers/laravel-crud-generator)[![Total Downloads](https://poser.pugx.org/webvelopers/laravel-crud-generator/downloads)](//packagist.org/packages/webvelopers/laravel-crud-generator)[![License](https://poser.pugx.org/webvelopers/laravel-crud-generator/license)](//packagist.org/packages/webvelopers/laravel-crud-generator)

## Introduction

Laravel CRUD Generator is a free library, it implements a new command to create: model, migration, factory, seeder, request and controller(resources) files with operations, with additional option to generate a full API Controller.

## License

Laravel CRUD Generator is open-sourced software licensed under the [MIT license](LICENSE).

## Instructions

On a laravel application you must be:

### 1. Install this library with composer

🔳 terminal/cmd

``` bash
composer require webvelopers/laravel-crud-generator
```

### 2. Generate all files with a one line of commands

Create a new Post

🔳 terminal/cmd

``` bash
php artisan crud:generator Post
```

### 3. Files Generated

#### Model

🗄️ app\Models\Post.php

``` php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        //
    ];
}
```

#### Migration

🗄️ database/migrations/2023_04_04_211632_create_posts_table.php

``` php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

#### Factory

🗄️ database/factories/PostFactory.php

``` php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            //'field' => fake()->word(),
        ];
    }
}
```

#### Seeder

🗄️ database/seeders/PostSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Post::factory()->count(100)->create();
    }
}
```

#### Store Request

🗄️ app/Http/Requests/StorePostRequest.php

``` php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
```

#### Update Request

🗄️ app/Http/Requests/UpdatePostRequest.php

``` php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
```

#### Controller

🗄️ app/Http/Controllers/PostController.php

``` php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): Response
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $post): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $post): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, int $post): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $post): Response
    {
        //
    }
}
```

#### Route

🗄️ routes/web.php

``` php
Route::resource('posts', \App\Http\Controllers\PostController::class);
```

### 3.1 Files extra with API option

Create a new Comment with API Controller

🔳 terminal/cmd

``` bash
php artisan crud:generator Comment --api
```

#### Controller API

🗄️ app/Http/Controllers/Api/CommentController.php

``` php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;

use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $comments = Comment::all();

        return response()->json($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $comment = Comment::create($request->all());

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $comment): JsonResponse
    {
        $comment = Comment::findOrFail($comment);

        return response()->json($comment, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, int $comment): JsonResponse
    {
        $comment = Comment::findOrFail($comment);
        $comment->update($request->all());

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $comment): JsonResponse
    {
        Comment::destroy($comment);

        return response()->json(null, 204);
    }
}
```

#### Route API

🗄️ routes/api.php

``` php
Route::apiResource('comments', \App\Http\Controllers\Api\CommentController::class);
```

### 4 Easy Edit Files Generated

#### Edit Model

🗄️ app\Models\Post.php

``` php
...
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
    ];
...
```

#### Edit Migration

🗄️ database/migrations/2023_04_04_211632_create_posts_table.php

``` php
...
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });
    }
...
```

#### Edit Factory

🗄️ database/factories/PostFactory.php

``` php
...
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'content' => fake()->paragraphs(5, true),
        ];
    }
...
```

#### Edit Seeder

🗄️ database/seeders/PostSeeder.php

``` php
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(100)->create();
    }
```

#### Edit Database Seeder

🗄️ database/seeders/DatabaseSeeder.php

``` php
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            PostSeeder::class,
        ]);
    }
```

#### Edit Store Request

🗄️ app/Http/Requests/StorePostRequest.php

```php
...
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
...
```

#### Edit Update Request

🗄️ app/Http/Requests/UpdatePostRequest.php

```php
...
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
...
```

### 5. Make Migration

``` bash
php artisan migrate --seed
```

Enjoy It

``` txt
made with ♥ by...
    __    __
    \/\/\/\/
     \/\/\/
      \/\/
www.webvelopers.net
```
