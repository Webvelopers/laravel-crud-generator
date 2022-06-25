# Laravel CRUD Generator

[![Latest Stable Version](https://poser.pugx.org/webvelopers/laravel-crud-generator/v)](//packagist.org/packages/webvelopers/laravel-crud-generator)[![Total Downloads](https://poser.pugx.org/webvelopers/laravel-crud-generator/downloads)](//packagist.org/packages/webvelopers/laravel-crud-generator)[![License](https://poser.pugx.org/webvelopers/laravel-crud-generator/license)](//packagist.org/packages/webvelopers/laravel-crud-generator)

## Introduction

Laravel CRUD Generator is a library, it implements a new command to create: model, migration, factory, seeder, request and controller(resources) files with operations, with additional option to generate a full API Controller.

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

For example, create a new Post

🔳 terminal/cmd

``` bash
php artisan crud:generator Post
```

Or create a new Post with API Controller

🔳 terminal/cmd

``` bash
php artisan crud:generator Post --api
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

🗄️ database/migrations/2022_06_25_000000_create_posts_table.php

``` php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
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
     *
     * @return array
     */
    public function definition()
    {
        return [
            //        
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
     *
     * @return void
     */
    public function run()
    {
        //Post::factory()->count(100)->create();
    }
}
```

#### Store Request

🗄️ app/Http/Requests/PostStoreRequest.php

``` php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
```

#### Update Request

🗄️ app/Http/Requests/PostUpdateRequest.php

``` php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $post
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostUpdateRequest $request
     * @param  mixed  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
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

#### Controller API

🗄️ app/Http/Controllers/Api/PostController.php

``` php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $post = Post::create($request->all());

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $post
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        $post = Post::findOrFail($post);

        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostUpdateRequest $request
     * @param  mixed  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $post)
    {
        $post = Post::findOrFail($post);
        $post->update($request->all());

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
    {
        Post::destroy($post);

        return response()->json(null, 204);
    }
}
```

#### Route API

🗄️ routes/api.php

``` php
Route::apiResource('posts', \App\Http\Controllers\Api\PostController::class);
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

🗄️ database/migrations/2022_06_25_000000_create_posts_table.php

``` php
...
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];
    }
...
```

#### Edit Seeder

🗄️ database/seeders/PostSeeder.php

``` php
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()->count(100)->create();
    }
```

#### Edit Database Seeder

🗄️ database/seeders/DatabaseSeeder.php

``` php
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PostSeeder::class);
    }
```

#### Edit Store Request

🗄️ app/Http/Requests/PostStoreRequest.php

```php
...
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
...
```

#### Edit Update Request

🗄️ app/Http/Requests/PostUpdateRequest.php

```php
...
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
