# Web Ujian Online CBT

Category: Web Programming
Notes: Tech Stack: Laravel 11, Spatie, Breeze, MySQL
Platform: Build with Angga (https://www.notion.so/Build-with-Angga-24f8c965d5788093a4f5c773370656ec?pvs=21)
Status: In progress
Url: https://buildwithangga.com/kelas/course-playing/z043x9dMjN/1

# About

Belajar membuat web untuk ujian online dengan menggunakan: Laravel 11, Tailwind, Spattie, Breeze

**Akses :** [https://buildwithangga.com/kelas/course-playing/z043x9dMjN/1](https://buildwithangga.com/kelas/course-playing/z043x9dMjN/1)

# Assets Link

- Discord : [https://discord.gg/3gUZTGUuUW](https://discord.gg/3gUZTGUuUW)
- Starter Template : [https://buildwithangga.com/kelas/download-materi/full-stack-web-development-bikin-projek-ujian-online-cbt/resources](https://buildwithangga.com/kelas/download-materi/full-stack-web-development-bikin-projek-ujian-online-cbt/resources)
- Figma Design : [https://www.figma.com/design/zaR1Q8LEKOY3DnGYz0tARx/bwa-cbt?node-id=0-1&t=s8cD5JmC6Fl1KARi-1](https://www.figma.com/design/zaR1Q8LEKOY3DnGYz0tARx/bwa-cbt?node-id=0-1&t=s8cD5JmC6Fl1KARi-1)

# Table of Contents

---

---

# Learning Notes

### Install and Setup Project

- Install laravel
    
    Guide: [https://laravel.com/docs/12.x/installation#creating-a-laravel-project](https://laravel.com/docs/12.x/installation#creating-a-laravel-project)
    
    - Pastikan sudah menginstall PHP dan Composer
    - Install laravel installer
        
        ```jsx
        composer global require laravel/installer
        ```
        
    - Create New Project
        
        ```jsx
        laravel new example-app
        ```
        
    - Jika sudah terbuat project, coba jalankan ini
        
        ```jsx
        cd example-app
        npm install && npm run build
        composer run dev
        ```
        
- Install Spatie
    
    Guide: [https://spatie.be/docs/laravel-permission/v6/installation-laravel](https://spatie.be/docs/laravel-permission/v6/installation-laravel)
    
    <aside>
    💡
    
    Spatie berfungsi sebagai package untuk manajemen role pada aplikasi web
    
    </aside>
    
    - Jalankan perintah berikut:
        
        ```jsx
        composer require spatie/laravel-permission
        ```
        
    
    - Jalankan perintah artisan berikut
        
        > Hal ini untuk **mem-publish file bawaan package (seperti migration dan config) ke dalam project Laravel agar bisa digunakan dan dimodifikasi**.
        > 
        
        ```jsx
        php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
        ```
        
    - Selanjutnya, kita bersihkan cache
        
        > `php artisan optimize:clear` atau `config:clear` dipakai untuk **membersihkan cache konfigurasi agar perubahan di config (misalnya config/permission.php) langsung terbaca sebelum menjalankan migrasi**.
        > 
        
        ```jsx
        php artisan config:clear
        ```
        
    - Karena masih ada konfigurasi yang akan dilakukan maka jangan dulu menjalankan  `php artisan migrate`
- Setting Database di env.
    - Buat database terlebih dahulu di mysql.
    - Atur menjadi seperti ini:
        
        ```jsx
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=cbt_bwa
        DB_USERNAME=root
        DB_PASSWORD=
        ```
        
    - **Jangan dulu** melakukan `php artisan migrate`
- Install Laravel Breeze
    
    Guilde: [https://laravel.com/docs/11.x/starter-kits#laravel-breeze](https://laravel.com/docs/11.x/starter-kits#laravel-breeze)
    
    <aside>
    💡
    
    Laravel Breeze itu package starter kit yang berguna untuk **menyediakan autentikasi (login, register, reset password, email verification) dengan kode simpel dan cepat dipakai**.
    
    > Akan otomatis mempunyai tampilan login sendiri, namun nanti bisa di custom
    > 
    </aside>
    
    - Command Install
        
        ```jsx
        composer require laravel/breeze --dev
        ```
        
    - Jalankan perintah installnya
        
        ```jsx
        php artisan breeze:install
        ```
        
    - Beberapa settingan ketika mengintall Breeze (Jika muncul)
        
        ```jsx
        Which Breeze stack would you like to install?
        > Blade with Alpine
        
        Would you like dark mode support? (yes/no)
        > No
        
        Which testing framework do you prefer?
        > PHPUnit
        ```
        
    - Lalu jalankan perintah migrate dan npm
        
        <aside>
        💡
        
        Pada tahap ini sudah otomatis mengintall tailwind via vite
        
        </aside>
        
        ```jsx
        php artisan migrate
        npm install
        npm run dev
        ```
        
    - Maka akan menjalankan di [`localhost:5173`](http://localhost:5173) ini adalah dimana vite nya berjalan.

### Create Seeder

<aside>
💡

Menyediakan data default saat project pertama kali dibuat

</aside>

- Membuat `RolePermissionSeeder`
    - Jalankan perintah artisan berikut.
        
        ```jsx
        php artisan make:seeder RolePermissionSeeder
        ```
        
    - Selanjutnya, Membuat Permisson.
    - Buka file `RolePermissionSeeder.php` yang baru saja digenerate tadi.
    - Tulisakan didalam function run.
        
        ```php
        $permissions = [
            'view_courses',
            'create_courses',
            'edit_courses',
            'delete_courses',
        ];
        ```
        
        > *Bisa nambah permissionlain. Misalnya: kode vocher, reward, kode promo.*
        > 
    - Lalu kita akan memasukan (insert) kedalam DB dengan menuliskan kode berikut tepat dibawahnya
        
        ```php
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);}
        ```
        
    
    <aside>
    💡
    
    **Perbedaan Role dan Permission**
    
    Role adalah kumpulan permission, 
    jadi **satu role bisa memiliki banyak permission (misalnya 2, 4, atau lebih), sedangkan permission adalah hak akses spesifik yang menentukan apa saja yang boleh dilakukan user.**
    
    </aside>
    
    - Selanjutnya, Membuat Role Teacher dan Student.
        
        <aside>
        💡
        
        Pastikan untuk mengimport
        
        ```php
        use Spatie\Permission\Models\Permission;
        use Spatie\Permission\Models\Role;
        use App\Models\User;
        ```
        
        atau saat menuliskan nama model, pastikan untuk mengkonfirmasi model nya, agar auto import.
        
        </aside>
        
    - Teacher Role memiliki semua permission.
        
        ```php
        $teacherRole = Role::create([
            "name" => "teacher",
        ]);
                
        $teacherRole->givePermissionTo([
            'view_courses',
            'create_courses',
            'edit_courses',
            'delete_courses',
        ]);
        ```
        
    - Student Role hanya memiliki view permission.
        
        ```php
        $studentRole = Role::create([
            'name' => 'student',
        ]);
        
        $studentRole->givePermissionTo([
            'view_courses',
        ]);
        ```
        
        > *Bisa saja student mempunyai permission lain seperti edit jawaban.*
        > 
        
        > Perhatikan penulisan permission. HARUS SAMA karena case sensitive. Penulisan harus sama seperti yang dideklarasikan di atas.
        > 
    - Membuat User Super Admin dan Memberinya Role
        
        ```php
        $user = User::create([
            "name" => "Super Admin",
            "email" => "superadmin@baycourse.com",
            "password" => bcrypt("12345678"),
        ]);
        
        $user->assignRole($teacherRole);
        ```
        
    
    <aside>
    💡
    
    **Membuat akun dan men-*assign*-kan role ke akun/user tersebut.** 
    
    Jadi konsepnya,
    Membuat akun lalu meng-assign role ke user, sehingga setiap role yang diberikan otomatis membawa semua permission yang melekat pada role tersebut ke user.
    
    </aside>
    
- Membuat `CategorySeeder`
    - Jalankan perintah artisan berikut.
        
        ```jsx
        php artisan make:seeder CategorySeeder
        ```
        
    
    <aside>
    💡
    
    Pastikan untuk mengimport
    
    ```php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    ```
    
    atau saat menuliskan nama model, pastikan untuk mengkonfirmasi model nya, agar auto import.
    
    Carbon untuk waktu, DB untuk ketika membuat table.
    
    </aside>
    
    - Didalam `CategorySeeder.php`, tuliskan
        
        ```php
        DB::table('categories')->insert([
            [
                'name' => 'Programming',
                'slug' => 'programming',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Product Design',
                'slug' => 'product-design',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        ```
        
- Menjalankan Seeder di `DatabaseSeeder.php`
    - Buka `DatabaseSeeder.php`
    - Hapus kodingan yang tertera yakni pada bagian “User:factory” nya
    - Tuliskan kodingan berikut:
        
        ```php
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
        ]);
        ```
        
    
    <aside>
    💡
    
    Namun ini akan **ERROR** karena tabel `categories` belum ada; saat ini di database hanya ada tabel default bawaan Laravel serta tabel dari Spatie dan Breeze, sedangkan tabel sesuai ERD kita belum dibuat.
    
    </aside>
    

### Create Model, Migrations, and Resource

<aside>
💡

Karena susunan tabel untuk aplikasi belum dibuat, maka dari itu kita perlu membuat migration nya terlebih dahulu sebelum menjalankan seeder.

</aside>

<aside>
💡

Nama Model haruslah dalam bentuk  **Singular** 

</aside>

- Untuk membuat model silakan jalankan perintah berikut.
    
    ```php
    php artisan make:model Category -mcr
    ```
    
    > `*-mcr` artinya kita akan sekalian membuat file migration, controller, dan resource controlller (template untuk CRUD di controller).*
    > 
- Lanjutkan membuat model Course, CourseStudent, CourseQuestion, CourseAnswer, StudentAnswer.
    
    ```php
    php artisan make:model Course -mcr
    php artisan make:model CourseStudent -mcr
    php artisan make:model CourseQuestion -mcr
    php artisan make:model CourseAnswer -mcr
    php artisan make:model StudentAnswer -mcr
    ```
    

### Arrange Attributes and Migrations

- Model Category Configuration
    - Masuk ke Model `Category.php`
    - Tambahkan traits
        
        ```php
        use HasFactory, SoftDeletes;
        ```
        
        Pastikan import nya tersedia
        
        ```php
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\SoftDeletes;
        ```
        
    - Lalu atur attribute / kolom yang boleh diisi dan tidak.
        
        > *guarded: Tidak bisa diisi, fillable: Data diisi.*
        > 
        
        ```php
        protected $guarded = [
           'id',
        ];
        ```
        
- Susun Migration
    - Buka file migrasi untuk category
    - Tambahkan ini pada function up
        
        ```php
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
        });
        ```
        
    - Lalu coba untuk melakukan migrasi dengan perintah
        
        ```php
        php artisan migrate
        ```
        
        Jika salah, bisa lakukan rollback untuk kembali satu batch saat migrate
        
        ```php
        php artisan migrate:rollback
        ```
        
    - Mengisi file migrasi courses, course_students, course_questions, course_answers, student_answers.
        
        ```php
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->string('cover');
            $table->timestamps();
        });
        ```
        
        ```php
        Schema::create('course_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        ```
        
        ```php
        Schema::create('course_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        ```
        
        ```php
        Schema::create('course_answers', function (Blueprint $table) {
            $table->id();
            $table->string('answer');
            $table->boolean('is_corrent');
            $table->foreignId('course_question_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        ```
        
        ```php
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->string('answer');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_question_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        ```
        
    
    <aside>
    💡
    
    **Cara melakukan Relasi**
    
    Cara 1:
    
    ```php
    $table->unsignedBigInteger('category_id');
    $table->foreign('category_id')->references('id')->on('categories');
    ```
    
    Cara 2:
    
    ```php
    $table->foreignId('category_id')->constrained();
    ```
    
    </aside>
    
    <aside>
    💡
    
    Kalau nama kolom foreign key-nya sama dengan pola default (misalnya `category_id` → tabel `categories`), maka constraint bisa dikosongin karena otomatis dikenali; tapi kalau namanya beda (misalnya `cate_id`), harus eksplisit direferensikan ke tabel tujuan.
    
    Contoh (Jika beda):
    
    ```php
    $table->foreignId('cate_id')->constrained('categories')->references('id');
    ```
    
    </aside>
    
    - Jika sudah kita akan menjalankan migrasi dengan perintah
        
        ```php
        php artisan migrate --seed
        ```
        
    - Jika terdapat error seperti ini:
        
        ```php
          Call to undefined method App\Models\User::assignRole()
        
          at vendor\laravel\framework\src\Illuminate\Support\Traits\ForwardsCalls.php:67
             63▕      * @throws \BadMethodCallException
             64▕      */
             65▕     protected static function throwBadMethodCallException($method)
             66▕     {
          ➜  67▕         throw new BadMethodCallException(sprintf(
             68▕             'Call to undefined method %s::%s()', static::class, $method
             69▕         ));
             70▕     }
             71▕ }
        
          1   vendor\laravel\framework\src\Illuminate\Support\Traits\ForwardsCalls.php:36
              Illuminate\Database\Eloquent\Model::throwBadMethodCallException("assignRole")
        
          2   vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php:2525
              Illuminate\Database\Eloquent\Model::forwardCallTo(Object(Illuminate\Database\Eloquent\Builder), "assignRole")
        ```
        
    - Kita perlu pergi ke Model User, lalu tambahkan
        
        ```php
        use HasFactory, Notifiable, HasRoles;
        ```
        
    - Jalankan Kembali
        
        ```php
        php artisan migrate:fresh --seed
        ```
        

### ORM Configuration

<aside>
💡

**Perbedaan Migration dan ORM**

**Migration** → dipakai buat bikin struktur dan relasi di database (misalnya foreign key, constraint, dll).

**ORM** → dipakai di level kode/aplikasi supaya kita bisa akses relasi itu dengan lebih gampang tanpa harus nulis query SQL manual.

</aside>

- Setup Model
    - Tambahkan Traits berikut pada setiap Model di dalam project. Yakni pada `Category.php, Category.php, CourseAnswer.php, CourseQuestion.php, CourseStudent.php, StudentAnswer.php`
        
        ```php
        use HasFactory, SoftDeletes;
        ```
        
        Jangan lupa untuk import namespace terlebih dahulu jika otomatis tidak ter-import
        
        ```php
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\SoftDeletes;
        ```
        
    - Buat protected guarded untuk id disetiap file terseut juga
        
        ```php
        protected $guarded = [
            'id',
        ];
        ```
        
- Setup Eloquent
    - Menghubungkan ORM `course` dengan `category` dan `category` dengan `course`
        
        ```php
        // Course.php
        
        public function category(){
            return $this->belongsTo(Category::class, 'category_id');
        }
        ```
        
        ```php
        // Category.php
        
        public function courses(){
            return $this->hasMany(Course::class, 'category_id', 'id');
        }
        ```
        
    - Menghubungkan ORM `course`dengan `question` dan `question` dengan `course`
        
        ```php
        // Course.php
        
            public function questions(){
                return $this->hasMany(CourseQuestion::class, 'course_id', 'id');
            }
        ```
        
        ```php
        
        // CourseQuestion.php
        
            public function course(){
                return $this->belongsTo(Course::class, 'course_id');
            }
        ```
        
    - Menghubungkan ORM CourseQuestion dan CourseAnswer
        
        ```php
        // CourseAnswer.php
        
            public function course_question(){
                return $this->belongsTo(CourseQuestion::class, 'course_question_id');
            }
        ```
        
        ```php
        // CourseQuestion.php
        
        public function course_answers(){
            return $this->hasMany(CourseAnswer::class, 'course_question_id', 'id');
        }
        ```
        
    - Menghubungkan User dengan Course dengan pivot table (CourseStudent) karena many-to-many
        
        ```php
        // User.php
            public function courses(){
                return $this->belongsToMany(Course::class, 'course_students', 'user_id', 'course_id');
            }
        ```
        
        ```php
        // Course.php
        
            public function users(){
                return $this->belongsToMany(User::class, 'course_students', 'course_id', 'user_id');
            }
        ```
        
    - Mengubungkan StudentAnswer dan Question
        
        ```php
        // StudentAnswer.php
        
            public function course_question(){
                return $this->belongsTo(CourseQuestion::class, 'course_question_id');
            }
        ```
        
        ```php
        // CourseQuestion.php
        
           public function student_answer(){
                return $this->hasOne(StudentAnswer::class, 'course_question_id', 'id');
            }
        ```
        

### Setup Views

- Buatlah folder ini didalam `resourses/views`
    
    ```markdown
    resources/views
    ├── auth
    ├── layouts
    ├── components
    ├── profile
    ├── admin        # folder khusus admin   
    ├── student      # folder khusus student 
    ├── dashboard.blade.php
    └── welcome.blade.php
    ```
    
- Didalam folder admin susun menjadi seperti berikut.
    
    ```markdown
    resources/views/admin
    ├── courses
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── manage.blade.php
    ├── questions
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── students
        └── add_student.blade.php
    ```
    
- Didalam folder student susun menjadi seperti berikut.
    
    ```markdown
    resources/views/student
    └── courses
        ├── index.blade.php
        ├── learning.blade.php
        ├── learning_finished.blade.php
        └── learning_raport.blade.php
    ```
    

### Routing

- Penjelasan Route Facade
    - Routing ditulis dengan menggunakan Facade `Route::` .
    - Facade tersebut ada banyak seperti:
    - 
        
        
        | Method | Kegunaan |
        | --- | --- |
        | Route::get($uri, $action) | Definisi route untuk HTTP GET |
        | Route::post($uri, $action) | Definisi route untuk HTTP POST |
        | Route::put($uri, $action) | Definisi route untuk HTTP PUT |
        | Route::patch($uri, $action) | Definisi route untuk HTTP PATCH |
        | Route::delete($uri, $action) | Definisi route untuk HTTP DELETE |
        | Route::options($uri, $action) | Definisi route untuk HTTP OPTIONS |
        | Route::match([$methods], $uri, $act.) | Definisi route dengan banyak method (GET/POST, dll) |
        | Route::any($uri, $action) | Definisi route yang menerima semua method |
        | Route::redirect($from, $to, $status) | Redirect dari 1 route ke route lain |
        | Route::view($uri, $view, $data=[]) | Route langsung return view tanpa controller |
        | Route::resource($name, $controller) | Generate route CRUD otomatis (index, create, store, show, edit, update…) |
        | Route::apiResource($n, $controller) | Sama seperti resource, tapi tanpa create/edit (buat REST API) |
        | Route::middleware($m)->group(fn) | Bungkus route dengan middleware tertentu |
        | Route::prefix($prefix)->group(fn) | Tambahkan prefix URL ke semua route dalam group |
        | Route::name($name)->group(fn) | Tambahkan prefix nama ke semua route dalam group |
        | Route::fallback($action) | Route fallback kalau nggak ada route yang match (404 custom) |
        | Route::group($attrs, $routes) | Grouping route dengan attributes (prefix, middleware, namespace, dll) |
- Routing Course for Teacher Role
    - Buka `web.php` pada folder routes.
    - Fokus penulisan route akan berada pada routes didalam group middleware auth.
    - Membuat group dengan prefix “dashboard”
        
        ```php
        Route::prefix('dashboard')->group(function(){
                
        });
        ```
        
    - Membuat rute courses dengan Facade resource agar semua function otomatis terbuat dan dibatasi dengan middleware teacher.
        
        ```php
        Route::resource('courses', CourseController::class)
        ->middleware('role:teacher');
        ```
        
        <aside>
        💡
        
        [!NOTE]
        
        **Apa itu `::class` di PHP?**
        
        - `::class` adalah **class name resolution operator** di PHP.
        - Kalau kamu tulis `CourseController::class`, PHP akan mengembalikan **string nama lengkap class beserta namespace-nya**.
        - Contoh:
            
            ```php
            echo CourseController::class;
            ```
            
            Output:
            
            ```
            App\Http\Controllers\CourseController
            ```
            
        - Jadi Laravel tau controller yang dimaksud itu class penuh, bukan sekadar string manual.
        </aside>
        
    - Cara mengecek route yang telah dibuat dengan menjalankan perintah
        
        ```php
        php artisan route:list
        ```
        
    - Terdapat route berikut.
        
        ```markdown
          GET|HEAD        dashboard/courses ...................................................................... courses.index › CourseController@index 
          POST            dashboard/courses ...................................................................... courses.store › CourseController@store 
          GET|HEAD        dashboard/courses/create ............................................................. courses.create › CourseController@create 
          GET|HEAD        dashboard/courses/{course} ............................................................... courses.show › CourseController@show
          PUT|PATCH       dashboard/courses/{course} ........................................................... courses.update › CourseController@update  
          DELETE          dashboard/courses/{course} ......................................................... courses.destroy › CourseController@destroy  
          GET|HEAD        dashboard/courses/{course}/edit .......................................................... courses.edit › CourseController@edit  
        ```
        
    
    <aside>
    💡
    
    **Route Resource di Laravel (CourseController)**
    
    - **index** → GET `/courses` → tampilkan semua data course.
    - **create** → GET `/courses/create` → halaman form buat tambah course baru.
    - **store** → POST `/courses` → simpan data course baru dari form.
    - **show** → GET `/courses/{id}` → tampilkan detail satu course (by id/slug).
    - **edit** → GET `/courses/{id}/edit` → halaman form edit course.
    - **update** → PUT/PATCH `/courses/{id}` → update data course yang ada.
    - **destroy** → DELETE `/courses/{id}` → hapus data course.
    
    <aside>
    🔑
    
    Yang cuma return view (GET halaman) → `index, create, show, edit`.
    Yang berhubungan sama aksi DB (fungsi) → `store, update, destroy`.
    
    </aside>
    
    </aside>
    
- Uji Coba Middleware dengan akun Teacher
    - Di jalankan aplikasi dengan perintah
        
        ```php
        composer run dev
        ```
        
    - Login dengan akun teacher lalu akses url [`http://127.0.0.1:8000/dashboard/courses`](http://127.0.0.1:8000/dashboard/courses)
    - Maka akan terdapat error seperti berikut.
        
        ```php
        Target class [role] does not exist.
        ```
        
        > Hal ini disebabkan karena role nya belum di daftarain di middleware.
        > 
    - Pergi ke `app.php` pada folder bootstrap.
    - Fokus pada bagian `withMiddleware` .
    - Selanjutnya akan mendaftarkannya dengan melihat dokumentasi spatie pada bagian middleware [`https://spatie.be/docs/laravel-permission/v6/basic-usage/middleware`](https://spatie.be/docs/laravel-permission/v6/basic-usage/middleware)
    - Silakan di-copy pada bagian ini.
        
        ```php
            ->withMiddleware(function (Middleware $middleware) {
                $middleware->alias([
                    'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
                    'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
                    'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
                ]);
            })
        ```
        
    - Lakukan refresh pada web dan berhasil
- Uji Coba Middleware dengan akun Student
    - Lakukan logout dan register akun baru
    - Akses ke url [`http://127.0.0.1:8000/dashboard/courses`](http://127.0.0.1:8000/dashboard/courses)
    - Lalu pada halaman akan muncul `403 | User does not have the right roles.`
        
        > Secara akses, ini sudah benar. Namun saat dicek pada database, user yang baru ini belum memiliki role. Maka kita perlu menambahkan kondisi yakni saat melakukan register akan di*assign*-kan sebagai “studentRole”.
        > 
    - Buka file `RegisteredUserController.php`
    - Fokus pada variabel `$user`
    - Karena role `student` sudah dibuat pada `RolePermissionSeeder.php` yakni tepat pada bagian
        
        ```php
        $studentRole = Role::create([
            'name' => 'student',
        ]);
        ```
        
    - Maka kita hanya perlu meng-*assign*-kan langsung rolenya dengan menambahkan ini dibawah variabel `$user`
        
        ```php
        $user->assignRole('student');
        ```
        
    - Coba registrasi kembali akun baru dan cek di DB.
    - Dan sudah terdaftar.
- Routing Lainnya for Teacher Role
    - Membuat group TeacherRole Middleware dan pindahkan route yang telah dibuat sebelumnya.
        
        ```php
        Route::middleware('role:teacher')->group(function () {
            Route::resource('courses', CourseController::class);
        });
        ```
        
    - Membuat route untuk mengelola quostion pada suatu course.
        
        ```php
        Route::get('/course/question/create/{course}', [CourseQuestionController::class, 'create'])
            ->name('course.create.question');
        Route::post('/course/question/save/{course}', [CourseQuestionController::class, 'store'])
            ->name('course.create.question.store');
        Route::resource('course_questions', CourseQuestionController::class);
        ```
        
    - Membuat route untuk mengelola student pada suatu course.
        
        ```php
        Route::get('/course/students/show/{course}', [CourseStudentController::class, 'index'])
            ->name('course.course_students.index');
        Route::get('/course/student/create/{course}', [CourseStudentController::class, 'create'])
            ->name('course.course_students.create');
        Route::post('/course/student/save/{course}', [CourseStudentController::class, 'store'])
            ->name('course.course_students.store');
        ```
        
- Routing for Student Role
    - Membuat group middleware role student.
        
        ```php
        Route::middleware(['role:student'])->group(function () {
                    
        });
        ```
        
    - Membuat LearningController dengan perintah
        
        ```php
        php artisan make:controller LearningController
        ```
        
    - Membuat routes learning
        
        ```php
        Route::get('/learning/finished/{course}', [LearningController::class, 'learning_finished'])
            ->name('learning.finished.course');
        Route::get('/learning/raport/{course}', [LearningController::class, 'learning_raport'])
            ->name('learning.raport.course');
        
        // Menampilkan beberapa kelas yang diberikan guru
        Route::get('/learning', [LearningController::class, 'index'])
            ->name('learning.index');
        Route::get('/learning/{course}/{question}', [LearningController::class], 'learning')
            ->name('learning.course');
        Route::post('/learning/{course}/{question}', [LearningController::class], 'store')
            ->name('learning.course.answer.store');
        ```
        

### Teacher Features

- Create Course
    - Buka file `create.blade.php` pada folder admin.
    - Tuliskan seperti ini untuk melakukan uji coba
        
        ```html
        <p>Testing Create Course</p>
        ```
        
    - Buka `CourseController.php`
    - Pada fungsi `create` lakukan return kepada views `create.blade.php`
        
        ```php
        return view('admin.courses.create');
        ```
        
    - Buka halaman [`http://127.0.0.1:8000/dashboard/courses/create`](http://127.0.0.1:8000/dashboard/courses/create) dengan akun Teacher.
    - Jika berhasil maka akan menampilkan “Testing Create Course”
    - Selanjutnya, akan mengadopsi tampilan berdasarkan template yang telah diberikan sebelumnya.
    - Buka template di window baru.
    - Salin semua yang ada pada `new-course.html` ke pada tampilan create di views.
    - Refresh kembali web. Maka akan ada beberapa masalah seperti assets dan css tidak terload.
    - Buat folder `css/output.css` di folder public. Lalu pastekan css yang sama dari template ke project.
    - Lakukan hal yang sama untuk folder `images`
    - Ubah import dari
        
        ```html
        <link href="./output.css" rel="stylesheet">
        ```
        
        menjadi
        
        ```html
        <link href={{ asset('css/output.css') }} rel="stylesheet">
        ```
        
    - Lakukan hal yang sama untuk src images pada file tersebut.
        
        ```php
        src="assets/images/icons/profile-2user.svg"
        ```
        
        ```php
        src= {{ asset('images/icons/profile-2user.svg') }}
        ```
        
    - Cari tag form untuk menginput data. Lalu tambahkan `@csrf, method,` dan `action.`
        
        ```html
        <form method="POST" action="{{ route('dashboard.course.store') }}" class="flex flex-col gap-[30px] w-[500px] mx-[70px] mt-10">
            @csrf
        </form>
        ```
        
    
    <aside>
    💡
    
    ⚡ **CSRF (Cross-Site Request Forgery)**
    
    **Apa itu?**
    
    Serangan di mana attacker nyuruh user tanpa sadar ngirim request berbahaya ke server (contoh: klik link, form otomatis submit).
    
    **Buat apa token CSRF?**
    
    → Buat **validasi request** beneran datang dari aplikasi kita, bukan dari website lain.
    
    → Jadi tiap form / request POST biasanya ada **CSRF token** yang unik.
    
    **Jenis serangan lain selain CSRF?**
    
    - **XSS (Cross-Site Scripting)** → nyelipin script jahat ke web.
    - **SQL Injection** → nyuntik query SQL jahat.
    - **Clickjacking** → user dikibulin klik sesuatu tanpa sadar.
    
    ✅ **Best practice**: selalu aktifkan proteksi CSRF (default di Laravel udah nyala), jangan matiin kecuali ada alasan kuat.
    
    </aside>
    
    - Lalu cari button untuk submit. Dia akan berbentuk a href
        
        ```html
        <a href="index.html"
           class="w-full h-[52px] p-[14px_20px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-center">
           Save Course
        </a>
        ```
        
        ```html
        <button type="submit" href="index.html"
           class="w-full h-[52px] p-[14px_20px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-center">
           Save Course
        </button>
        ```
        
    - Selanjutya, periksa masukan dari form. Kita akan mengganti “name” pada tag input sesuai dengan nama kolom atau attribute yang ada pada database. Pastikan name sebagai berikut.
        
        > cover, name, category_id
        > 
    - Selanjutnya, akan menampilkan daftar category pada form dengan menuliskan kode berikut pada `CourseController.php` bagian `create`.
        
        ```php
        $categories = Category::all();
        return view('admin.courses.create', [
            'categories' => $categories,
        ]);
        ```
        
        <aside>
        📌
        
        ## Callout: `$categories = Category::all();`
        
        ### 🟢 Kenapa pakai `Category::all();`?
        
        - `all()` itu method bawaan **Eloquent ORM** (Object Relational Mapping) di Laravel.
        - Fungsinya: **ngambil semua data dari tabel categories** terus balikin dalam bentuk **Collection** (mirip array, tapi lebih powerfull).
        
        ### 🔀 Alternatif selain `all()`
        
        - `Category::find(1)` → cari data berdasarkan id.
        - `Category::where('status', 'active')->get()` → ambil data dengan kondisi tertentu.
        - `Category::first()` → ambil 1 data pertama.
        - `Category::pluck('name')` → ambil hanya kolom `name`.
        - `Category::count()` → hitung jumlah data.
        </aside>
        
        <aside>
        🧩
        
        ### 🧩 Bagian `return view(...)`
        
        ```php
        return view('admin.courses.create', [
            'categories' => $categories,
        ]);
        
        ```
        
        - `view('admin.courses.create')` → ngarah ke file Blade `resources/views/admin/courses/create.blade.php`.
        - Bagian array `['categories' => $categories]` → **key-value pair**.
            - `'categories'` = **nama variabel** yang bisa dipanggil di view Blade.
            - `$categories` = data yang dikirim.
        
        Di Blade bisa dipanggil gini:
        
        ```
        @foreach ($categories as $category)
           <p>{{ $category->name }}</p>
        @endforeach
        ```
        
        </aside>
        
    - Lalu mapping di views.
        
        ```php
        @forelse ($categories as $category)
            <option value={{ $category->id }} class="font-semibold">
                {{ $category->name }}
            </option>
        @empty
            // empty record condition
        @endforelse
        ```
        
        <aside>
        💡
        
        Foreach vs. Forelse
        
        - `@foreach` → simple loop, tapi harus bikin `@if` tambahan buat handle empty.
        - `@forelse` → lebih ringkas karena udah ada fallback bawaan.
        </aside>
        
    - Simpan kedalam database, buka function store dan tuliskan
        
        ```php
        $validated = $request->validate([
            'name' => "required|string|max:255",
            'category_id' => "required|integer",
            'cover' => "required|image|mimes:png,jpg,svg",
        ]);
        
        DB::beginTransaction();
        try {
            if ($request->hasFile('cover')) {
                $coverPath = $request->file('cover')->store('product_covers', 'public');
                $validated['cover'] = $coverPath;
        
                $validated['slug'] = Str::slug($request->name);
                $newCourse = Course::create($validated);
                DB::commit();
        
                return redirect()->route('courses.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $err = ValidationException::withMessages([
                'system_error' => ['System Error!' . $e->getMessage()],
            ]);
        
            throw $err;
        }
        ```
        
        <aside>
        💡
        
        **Catatan**
        
        - `\Exception` → backslash buat akses class global di PHP (namespace root). Bahasa lain juga ada konsep `Exception` buat error handling.
        - `DB::beginTransaction()` & `DB::commit()` → disebut **transaction**. Dipakai biar query jalan aman (kalau error → rollback). Tanpa ini, data bisa nyangkut setengah jalan.
        - `$request->file(...)->store(..., 'public')` → `request` emang banyak method (`input()`, `file()`, `all()`, dll). `store()` nyimpen file ke **disk**.
        - `'public'` → nama **disk** di `config/filesystems.php`. Selain `public` ada `local`, `s3`, dll. Wajib ditulis biar tau nyimpennya ke mana.
        - `Str::slug()` → helper bikin slug (judul jadi URL-friendly).
        - `ValidationException::withMessages([...])` → cara custom error message biar bisa dilempar balik ke form.
        </aside>
        
    - Kembali ke file `create.blade.php`
    - Lalu cari “Access Type”
    - Ganti option jadi hanya satu yakni “Invitation Only”
    - Lalu cari diatas tag form dan tambahkan kode berikut untuk menampilkan pesan error.
        
        ```php
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $err)
                    <li class="p-5 bg-red-700 text-white rounded-md">{{ $err }}</li>
                @endforeach
            </ul>
        @endif
        ```
        
    - Selanjutnya, coba masukan data.
    - Akan muncul error
        
        ```php
        The cover field must be an image.
        The cover field must be a file of type: png, jpg, svg.
        ```
        
    - pergi ke tag form dan tambahkan attribute ini
        
        ```php
        enctype="multipart/form-data"
        ```
        
    - Coba masukan data kembali.
    - Lalu jika sudah berhasil jalankan perintah berikut.
        
        ```php
        php artisan storage:link
        ```
        
    
    <aside>
    💡
    
    **File Upload Essentials di Laravel**
    
    - `enctype="multipart/form-data"` → WAJIB kalau ada `<input type="file">`, biar file bisa ikut terkirim.
    - `php artisan storage:link` → bikin link `public/storage` ke `storage/app/public`, biar file yang udah di-upload bisa diakses lewat browser.
    </aside>
    
- Displaying All Course
    - Coba tambahkan 5 course terlebih dahulu
    - Copy template `index.html` ke `resources/views/courses/index.blade.php`
    - Lakukan hal yang sama untuk import `css` dan `assets`
    - Cari card list item di template, lalu sisakan hanya 1 (karena nanti akan digunakan `@forelse`)
    - Hapus pagination bawaan template (nanti bisa coba implementasi pagination Laravel)
    - Di `CourseController` pada fungsi `index`:
        
        ```php
        public function index() {
            $courses = Course::orderBy('id', 'desc')->get();
            return view('courses.index', compact('courses'));
        }
        ```
        
    - Lempar variabel `$courses` ke view
    - Tampilkan setiap data menggunakan `@forelse`
        
        ```php
        @forelse($courses as $course)
            // tampilan card
        @empty
            <p>Tidak ada course.</p>
        @endforelse
        ```
        
    - Cover course tampilkan menggunakan `Storage::url($course->cover)`
    - Nama course tampilkan menggunakan `{{ $course->name }}`
    - Tombol **Add New Course** arahkan ke route `courses.create`
    - Untuk category gunakan `{{ $course->category->name }}`
    - Jika ingin warna category berbeda, gunakan `if else`
    - Tanggal dibuat gunakan Carbon
        
        ```php
        {{ \Carbon\Carbon::parse($course->created_at)->format('F j, Y') }}
        ```
        
- Edit and Delete Course
    - di index.blade.php: tombol edit mengarah ke halaman edit (bawa instance course), delete dibungkus form
        
        ```
        {{-- Edit --}}
        <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">Edit</a>
        
        {{-- Delete --}}
        <form action="{{ route('courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Yakin hapus course ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
        
        ```
        
    - controller: method edit → ambil 1 course + categories, lempar ke view edit
        
        ```php
        // app/Http/Controllers/CourseController.php
        use App\Models\Course;
        use App\Models\Category;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\DB;
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Str;
        
        public function edit(Course $course)
        {
            $categories = Category::select('id','name')->orderBy('name')->get();
            return view('admin.courses.edit', compact('course','categories'));
        }
        
        ```
        
    - buat view edit (copy dari create), ganti action ke update, tambah @method('PUT'), isian diprefill, cover tidak required
        
        ```
        {{-- resources/views/admin/courses/edit.blade.php --}}
        <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        
            {{-- Name --}}
            <input type="text" name="name" value="{{ old('name', $course->name) }}">
        
            {{-- Category --}}
            <select name="category_id">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        
            {{-- Current Cover Preview --}}
            @if ($course->cover)
                <img src="{{ Storage::url($course->cover) }}" alt="cover" style="max-height:120px">
            @endif
        
            {{-- New Cover (optional) --}}
            <input type="file" name="cover"> {{-- jangan pakai required di edit --}}
        
            <button type="submit">Update</button>
        </form>
        
        ```
        
    - controller: method update → validasi, optional ganti cover, update data, redirect ke index
        
        ```php
        public function update(Request $request, Course $course)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:categories,id',
                'cover' => 'sometimes|image|mimes:png,jpg,jpeg,svg',
            ]);
        
            DB::transaction(function () use ($request, $course, &$validated) {
                if ($request->hasFile('cover')) {
                    $newPath = $request->file('cover')->store('product_covers', 'public');
                    // hapus cover lama jika ada
                    if ($course->cover) {
                        Storage::disk('public')->delete($course->cover);
                    }
                    $validated['cover'] = $newPath;
                }
        
                $validated['slug'] = Str::slug($request->name);
                $course->update($validated);
            });
        
            return redirect()->route('courses.index')->with('success', 'Course updated.');
        }
        
        ```
        
    - delete di controller: hapus file cover (jika ada), lalu delete record, redirect ke index
        
        ```php
        public function destroy(Course $course)
        {
            DB::transaction(function () use ($course) {
                if ($course->cover) {
                    Storage::disk('public')->delete($course->cover);
                }
                $course->delete();
            });
        
            return redirect()->route('courses.index')->with('success', 'Course deleted.');
        }
        
        ```
        
    
    <aside>
    💡
    
    **Callout singkat**
    
    - `@method('PUT')` & `@method('DELETE')` = method spoofing untuk form (karena HTML form hanya dukung GET/POST).
    - input file di edit **tidak required**; pakai rule `sometimes` pada validasi.
    - gunakan `Storage::url($course->cover)` untuk preview; pastikan sudah `php artisan storage:link`.
    </aside>
    
    <aside>
    💡
    
    **Perbedaan `update()` vs `updated` di Laravel**
    
    - 🔹 **`update()`**
        
        → Method bawaan Eloquent.
        
        → Dipakai buat **mengubah data di database**.
        
        → Contoh:
        
        ```php
        $course->update(['name' => 'Laravel Dasar']);
        
        ```
        
        ✅ Efek: langsung bikin query `UPDATE` ke DB.
        
    - 🔹 **`updated`**
        
        → Event bawaan Eloquent.
        
        → **Otomatis dipanggil setelah data berhasil di-update**.
        
        → Cocok buat logging, notifikasi, trigger otomatis.
        
        → Contoh di model:
        
        ```php
        protected static function booted()
        {
            static::updated(function ($course) {
                \Log::info("Course {$course->id} updated jadi {$course->name}");
            });
        }
        
        ```
        
        ✅ Efek: event jalan otomatis setelah `update()` berhasil.
        
    </aside>
    
- Manage Course (Show Detail)
    - Pergi ke `CourseController.php` lalu fokus pada fungsi show.
    - Tulis kode seperti ini
        
        ```php
        return view('admin.courses.manage', [
            "course" => $course,
        ]);
        ```
        
    - pada `index.blade.php` di admin, cari card list dropdown href manage, lalu arahkan ke route `courses.show`
        
        ```php
        
        <a href="{{ route('courses.show') }}"
            class="flex items-center justify-between font-bold text-sm w-full">
            Manage
        </a>
        ```
        
    - Copy isi file `course_details.html` pada template. Dan pastekan pada `manage.blade.php`
    - Lalu perbaiki untuk import css dan assetsnya.
    - Selanjutnya, pergi ke breadcrumb, Nah silakan perbaikan url nya begitu pun dengan halaman create dan edit sebelumnya.
        
        ```php
        <div class="breadcrumb flex items-center gap-[30px]">
            <a href={{ route('dashboard') }} class="text-[#7F8190] last:text-[#0A090B] last:font-semibold">
                Home
            </a>
            <span class="text-[#7F8190] last:text-[#0A090B]">/</span>
            <a href={{ route('courses.index') }}
                class="text-[#7F8190] last:text-[#0A090B] last:font-semibold">Manage
                Courses
            </a>
            <span class="text-[#7F8190] last:text-[#0A090B]">/</span>
            <a href="#"
            class="text-[#7F8190] last:text-[#0A090B] last:font-semibold ">Course
                Details
            </a>
        </div>
        ```
        
    - Kembali ke halaman manage, silakan disesuaikan untuk data course name, course category, dll
    - Untuk jumlah student, kembali ke function `show` di controller. Tuliskan kode berikut.
        
        ```php
        $students = $course->users()->orderBy('id', 'DESC')->get();
            return view('admin.courses.manage', [
                "course" => $course,
                "students" => $students,
        ]);
        ```
        
    - Pada views tampilkan count
        
        ```php
        <p class="font-semibold">{{ count($students) }} students</p>
        ```
        
    - Menampilkan Question pada Detail Course
        - Pada `CourseController.php` fungsi `show`
        - Buat variabel questions untuk menampilkan semua question yang dimiliki oleh course tersebut. Caranya sama seperti jumlah students
        - Selanjutnya lakukan forelse untuk nge-mapping list pertanyaan
    - Membuat halaman Create Question
        - Pada bagian href “New Question” ganti route ke `course.create.question` dengan parameter `$course`
        - Buka `CourseQuestionController.php` dan fokus pada fungsi `create`
        - Masukan parameter $course pada fungsi tersebut.
            
            ```php
            public function create(Course $course)
            ```
            
        - Lakukan debugging terlebih dahulu
            
            ```php
            dd($course);
            ```
            
        - Selanjutnya return view ke `admin.question.create` dan lempar `$course` nya
            
            ```php
            return view('admin.questions.create', [
                'course' => $course,
            ]);
            ```
            
        - Selanjutnya, copy isi template `add-question.html` ke `create.blade.php` pada level questions
        - Lakukan hal yang sama untuk css dan assets.
        - Lalu sesuaikan data untuk coursenya sama seperti tadi.
        - Fokus ke bagian tag form
        - Tambahkan method, action, dan csrf
            
            ```html
            <form method="POST" action="{{ route('course.create.question.store', $course) }}" id="add-question" class="mx-[70px] mt-[30px] flex flex-col gap-5">
                @csrf
            </form>
            ```
            
        - Selanjutnya perhatikan dan ganti `name` attribute pada setiap tag input. Sesuaikan dengan nama attribut di database.
        - Lalu pada list answer (ada 4), hapus dan sisakan 1. Karena nantinya akan digunakan perulangan
            
            ```php
            @for ($i; $i<4; $i++)
                                    
            @endfor
            ```
            
        - Ubah `name` pada input menjadi sebagai berikut
            
            ```php
            // Before
            name="answer-1"
            
            // After
            name="answers[]"
            ```
            
            <aside>
            💡
            
            **Apa itu answers[]**
            
            </aside>
            
        - Masuk ke radio button untuk `correct` , name nya ganti jadi `correct_answer`
        - Lalu ke “Save Question”, ganti menjadi `button` dan type `submit`
            
            ```html
            <button type="submit"
                class="w-[500px] h-[52px] p-[14px_20px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-center">
                Save Question
            </button>
            ```
            
        
    - Mengimplementasikan Store Question
        - Masuk ke file `CourseQuestionController.php` cari function store.
        - Tambah parameter course buat tangkap hasil lemparan.
            
            ```php
            Course $course
            ```
            
        - Buat jadi seperti ini
            
            ```php
            $validated = $request->validate([
                        'question' => 'required|string|max:255',
                        'answers' => 'required|array',
                        'answers.*' => 'required|string|max:255',
                        'correct_answer' => 'required|integer',
                    ]);
            
                    DB::beginTransaction();
            
                    try {
                         $question = $course->questions()->create([
                            'question' => $request->question,
                        ]);
            
                        foreach ($request->answers as $index => $answerText) {
                            $isCorrect = $request->correct_answer == $index;
            
                            $question->course_answers()->create([
                                'answer' => $answerText,
                                'is_corrent' => $isCorrect,
                            ]);
                        }
            
                        DB::commit();
            
                        return redirect(route('courses.show', $course->id));
            
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $err = ValidationException::withMessages([
                            'system_error' => ['System Error!' . $e->getMessage()],
                        ]);
            
                        throw $err;
                    }
            ```
            
            <aside>
            💡
            
            > `'answers.*' => 'required|string|max:255'`
            > 
            > 
            > 👉 Tanda `*` artinya **setiap elemen di dalam array `answers[]`** harus lolos aturan ini.
            > 
            > Jadi:
            > 
            > - Wajib diisi (`required`)
            > - Harus berupa teks (`string`)
            > - Maksimal 255 karakter
            
            > Misalnya input dari form kamu:
            > 
            > 
            > ```php
            > answers => ["Option 1", "Option 2", "Option 3", ""]
            > ```
            > 
            > Maka item terakhir `""` (kosong) bakal gagal validasi karena `required`.
            > 
            </aside>
            
        - Tambahkan error message diatas tag form
            
            ```php
            @if ($errors->any())
                            <ul class="p-5 bg-red-700 text-white rounded-md">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        @endif
            ```
            
        - Tambah attribute value pada radio button `correct_answer`
            
            ```php
            value="{{ $i }}"
            ```
            
        - Lalu Tambahkan 5 Pertanyaan untuk masing masing course.
    - Mengimplementasikan Edit and Update Question
        - Copy kodingan pada `create.blade.php` level *question* ke `edit.blade.php` level *question.*
        - Ganti action pada tagform menjadi
            
            ```php
            action="{{ route('course_questions.update', $courseQuestion) }}"
            ```
            
        - Cari button *edit* di `manage.blade.php` ubah route jadi ke question.edit
            
            ```php
            <a href="{{ route('course_questions.edit', $question) }}"
            ```
            
        - Masuk ke file `CourseQuestionController.php` cari fungsi edit.
        - Lalu return view seperti ini
            
            ```php
            public function edit(CourseQuestion $courseQuestion)
                {
                    $course = $courseQuestion->course;
                    $students = $course->users()->orderBy('id', 'DESC')->get();
                    return view('admin.questions.edit', [
                        "course" => $course,
                        "courseQuestion" => $courseQuestion,
                        "students" => $students,
                    ]);
                }
            ```
            
        - Selanjutnya ke `edit.blade.php` pada level *question*
        - Lalu, silakan munculkan value question dan answernya. Answernya ganti pakai foreach.
            
            ```php
                                @foreach ($courseQuestion->course_answers as $index => $answer)
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="flex items-center w-[500px] h-[52px] p-[14px_16px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B]">
                                            <div class="mr-[14px] w-6 h-6 flex items-center justify-center overflow-hidden">
                                                <img src="{{ asset('images/icons/edit.svg') }}"
                                                    class="h-full w-full object-contain" alt="icon">
                                            </div>
                                            <input type="text" value="{{ $answer->answer }}"
                                                class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none"
                                                placeholder="Write better answer option" name="answers[]">
                                        </div>
                                        <label class="font-semibold flex items-center gap-[10px]">
                                            <input type="radio" name="correct_answer" required
                                                value="{{ $index }}" 
                                                {{ $answer->is_corrent ? 'checked' : '' }}
                                                class="w-[24px] h-[24px] appearance-none checked:border-[3px] checked:border-solid checked:border-white rounded-full checked:bg-[#2B82FE] ring ring-[#EEEEEE]" />
                                            Correct
                                        </label>
                                    </div>
                                @endforeach
            ```
            
        - Masuk ke controller `CourseQuestionController.php` dan fungsi update.
        - Tuliskan kode berikut
            
            ```php
            public function update(Request $request, CourseQuestion $courseQuestion)
                {
                    $validated = $request->validate([
                        'question' => 'required|string|max:255',
                        'answers' => 'required|array',
                        'answers.*' => 'required|string|max:255',
                        'correct_answer' => 'required|integer',
                    ]);
            
                    DB::beginTransaction();
            
                    try {
                        $courseQuestion->update([
                            'question' => $request->question,
                        ]);
            
                        // Hapus data jawaban
                        $courseQuestion->course_answers()->delete();
                        foreach ($request->answers as $index => $answerText) {
                            $isCorrect = $request->correct_answer == $index;
            
                            $courseQuestion->course_answers()->create([
                                'answer' => $answerText,
                                'is_corrent' => $isCorrect,
                            ]);
                        }
            
                        DB::commit();
            
                        return redirect(route('courses.show', $courseQuestion->course_id));
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $err = ValidationException::withMessages([
                            'system_error' => ['System Error!' . $e->getMessage()],
                        ]);
            
                        throw $err;
                    }
                }
            ```
            
        - Tambahkan method PUT/PATCH di form nya.
        - Lalu dicobian
    - Delete Question
        - Cari form delete di `manage.blade.php`
        - Tambah method dan action menjadi
            
            ```php
            <form method="POST" action="{{ route('course_questions.destroy', $question) }}">
                csrf
                method('DELETE')
                <button type="submit"
                    class="w-[52px] h-[52px] flex shrink-0 items-center justify-center rounded-full bg-[#FD445E]">
                    <img src="{{ asset('images/icons/trash.svg') }}" alt="icon">
                </button>
            </form>
            ```
            
        - Pada controller tulis menjadi
            
            ```php
            public function destroy(CourseQuestion $courseQuestion)
                {
                    try {
                        $courseQuestion->delete();
                        return redirect()->route('courses.show', $courseQuestion->course_id);
                    } catch (\Exception $e) {
                        $err = ValidationException::withMessages([
                            'system_error' => ['System Error!' . $e->getMessage()],
                        ]);
            
                        throw $err;
                    }
                }
            ```
            
        - Selesai.
    - Add Students
        - Cari link atau button “Add Students”
        - Arahkan ke route `course.course_students.create` dan lempar parameter course
        - Lalu buka `CourseStudentController.php` cari fn create.
        - Tangkep parameter course, lalu debugging.
        - Jika bisa, return view ke admin.students.add_student dan lempar variabel course
        - Lalu pindahkan tampilan dari template ke project dan sesuaikan isinya seperti course name dan lain lain.
            
            > Fungsi `count()` itu namanya **Laravel Collections**.
            > 
        - Cari tag form
        - Tambah csrf, action, method, jangan lupa lempar parameter course nya
            
            ```php
            <form method="POST" action="{{ route('course.course_students.store', $course) }}" id="add-question" class="mx-[70px] mt-[30px] flex flex-col gap-5">
            ```
            
        - Masuk ke `CourseStudentController.php` lalu cari fungsi store.
        - Tangkep parameter `$course`
        - Tuliskan sebegai berikut
            
            ```php
            public function store(Request $request, Course $course)
                {
                    $validated = $request->validate([
                        'email' => 'required|string|email',
                    ]);
            
                    $user = User::where('email', $request->email)->first();
                    if (!$user) {
                        $err = ValidationException::withMessages([
                            'system_error' => ['Email student tidak tersedia!'],
                        ]);
            
                        throw $err;
                    }
            
                    $isEnrolled = $course->users()->where('user_id', $user->id)->exists();
                    if ($isEnrolled) {
                        $err = ValidationException::withMessages([
                            'system_error' => ['Student sudah terdaftar pada course ini'],
                        ]);
            
                        throw $err;
                    }
            
                    DB::beginTransaction();
            
                    try {
                        
                        $course->users()->attach($user->id);
                        DB::commit();
            
                        return redirect(route('courses.show', $course));
            
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $err = ValidationException::withMessages([
                            'system_error' => ['System Error!' . $e->getMessage()],
                        ]);
            
                        throw $err;
                    }
                }
            ```
            
        - Buat kondisi pesan error di atas form sama seperti sebelumnya.
    - Solve Tailwind
        - Pergi ke web https://tailwindcss.com/docs/installation/play-cdn
        - Pastekan kode ini di dalam tag head
            
            ```php
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
            ```
            

### Logout Feautures

- Sudah ada di `navigaton.blade.php`
- Salin kodingan tersebut.
- Omplementasikan di `manage.blade.php` dan lainnya
- Jika ada kesalahan ui silakan diperbaiki saja.

### Student Features

- Dashboard Student
    - Logout dan masuk kembali dengan akun student
    - Pada navigation, Tambahkan navigasi baru disebelah dashboard. Dan lakukan perkondisin untuk role nya
        
        ```php
        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>
        
            @role('teacher')
                <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.index')">
                    {{ __('Manage Course') }}
                </x-nav-link>
            endrole
                            
            @role('student')
                <x-nav-link :href="route('learning.index')" :active="request()->routeIs('learning.index')">
                    {{ __('My Course') }}
                </x-nav-link>
            @endrole
        </div>
        ```
        
- Tampilan My Course
    - Masuk ke `LearningController.php` di index direturn ke view `student.courses.learning`
    - Salin isi file `my-course.html` ke file `learning.blade.php`
    - Perbaiki CSS dan Assets.
- Menampilkan Daftar Course
    - Cari course list pada `learning.blade.php` lalu sisakan 1 saja.
    - Masuk ke `LearningController.php` fokus ke *index*
        
        ```php
         public function index()
            {
                $user = Auth::user();
                $my_courses = $user->courses()->with('category')->orderBy('id', 'DESC')->get();
        
                return view('student.courses.learning', [
                    'my_courses' => $my_courses
                ]);
            }
        ```
        
    - Pada view lakukan forelse
        
        ```php
        @forelse ($my_courses as $course)
                            <div class="list-items flex flex-nowrap justify-between pr-10">
                                <div class="flex shrink-0 w-[300px]">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 flex shrink-0 overflow-hidden rounded-full">
                                            <img src="{{ asset('images/thumbnail/Digital-Marketing-101.png') }}"
                                                class="object-cover" alt="thumbnail">
                                        </div>
                                        <div class="flex flex-col gap-[2px]">
                                            <p class="font-bold text-lg">Digital Marketing 101</p>
                                            <p class="text-[#7F8190]">Beginners</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex shrink-0 w-[150px] items-center justify-center">
                                    <p class="font-semibold">11 March 2024</p>
                                </div>
                                <div class="flex shrink-0 w-[170px] items-center justify-center">
                                    <p class="p-[8px_16px] rounded-full bg-[#D5EFFE] font-bold text-sm text-[#066DFE]">
                                        Marketing
                                    </p>
                                </div>
                                <div class="flex shrink-0 w-[120px] items-center">
                                    <a href="{{ route('learning.course', ['course' => $course->id, 'question' => $course->nextQuestionId]) }}"
                                        class="w-full h-[41px] p-[10px_20px] bg-[#6436F1] rounded-full font-bold text-sm text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-center">
                                        Start Test
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">Belum ada course diberikan</p>
                        @endforelse
        ```
        
    - Lakukan pergantian data / nama seperti sebelum sebelumnya
    - Copy bagian logout nya juga.
    - Ganti nama di navbar (Lakukan ditempat lain juga)
        
        ```php
        <p class="font-semibold">{{ Auth::user()->name }}</p>
        ```
        
- Submit Test
    - Cari tombol “Start Test”
        
        ```php
        <a href="{{ route('learning.course', ['course' => $course->id, 'question' => $course->nextQuestionId]) }}"
        ```
        
        Karena pada route membutuhkan 2 parameter (`'/learning/{course}/{question}'`) maka akan ditulis seperti itu.
        
        <aside>
        💡
        
        **Cara benar passing parameter ke `route()`**
        
        ```php
        <a href="{{ route('learning.course', ['course' => $course->id, 'question' => $course->nextQuestionId]) }}"
        ```
        
        ✅ Gunakan **associative array** (key → nama parameter di route).
        
        Biar Laravel tau persis `{course}` diisi `$course`, `{question}` diisi `$question`.
        
        ❌ Jangan cuma `[$course, $question]`, karena itu cuma mengandalkan **urutan**, rawan error kalau urutan/nama param berubah.
        
        </aside>
        
    - Masuk ke `LearningController.php` buat fokus ke index
    - Ganti jadi
        
        ```php
        public function index()
            {
                $user = Auth::user();
                $my_courses = $user->courses()->with('category')->orderBy('id', 'DESC')->get();
        
                // Karena akan melempar 'NextQuestionId' maka akan berbeda beda, oleh karena itu perlu dimapping secara satu per satu.
                foreach ($my_courses as $course) {
                    // Cek jumlah pertanyaan
                    $totalQuestionsCount = $course->questions()->count();
        
                    // Jumlah yang sudah dikerjakan
                    $answeredQuestionsCount = StudentAnswer::where('user_id', $user->id)
                        ->whereHas('course_question', function ($query) use ($course) {
                            $query->where('course_id', $course->id);
                        })->distinct()->count('course_question_id');
        
                    // Setting NextQuestionId
                    if ($answeredQuestionsCount < $totalQuestionsCount) {
                        // Mencari nomor pertama yang belum dijawab
                        $firstUnanswerdQuestion = CourseQuestion::where('course_id', $course->id)
                            ->whereNotIn('id', function ($query) use ($user) {
                                $query->select('course_question_id')->from('student_answers')
                                    ->where('user_id', $user->id);
                            })->orderBy('id', 'ASC')->first();
        
                            $course->nextQuestionId = $firstUnanswerdQuestion ? $firstUnanswerdQuestion->id : null;
                    } else {
                        $course->nextQuestionId = null;
                    }
                }
        
                return view('student.courses.learning', [
                    'my_courses' => $my_courses
                ]);
            }
        ```
        

sampe submit test part 2

part 3

- tangkepparameter course question di store di studentanswr controller
- buat var questionDetails, first
- validasi data, req answer_id -> req|exists:course_answers, id
- begintrancsac
- try and catch
- selectedAnswer = pastiin ada di courseAnswer pakai where id
- dd in bos
- kalau ngga ada, error sama, paling pesan error nya ubah ("Jawaban tidak tersedia")
- buat var existinganswer, pakai model StudentAnswer (udah jawab belum) pakai where user id, where course question id, first
- nah akalu exist, tampilin error lagi, message nya: Kamu telah menjawab pertanyaan ini sebelumnya.
- bikin var answerValue = selectedAnswer->is_correct ? "correct" : "wrong" jadi nanti di db di kolom answer nya wrong atau correct
- create student answer pakai 3 kolom, user_id AUth::id()
- commit in bre

Part 4:

- bikin nextQuestion
- CourseQuestion cek course id, ehre id question > question, orderbt id asc, first
- cek if nextQuestion, kalau ada redirest ke learning course, dan lempar course dan question=> nextQuestion->id.
- else (kalau pertanyaan terakhir) = redirest dashbord finish course, lempar course id
- coba dan cek DB
- ke index, akan buat condotional utuk yang sudah selesai
- pakai if nextQuestio !== null
- buat else, kasih view raport

buat rapport

- biasa terapin template rapport details
- di conttroller bua tfn rapport tangket kelas
- return view dan lempar corse
- tambah rute di button rapport pake course
- biasa ganti value course name dan lain lain
- menampilkan pertanyaan
- ke controler
- bikin var userid
- dapatkan studentAnswer with question, where has question use course, query where course_id course->id
- where user_id userid
- bikin total question
- bikin correct StudentAnswer, answer, where answer correct
- bikin variabel passed, correct answe == total
- lempar passed, coursem studentAnswer, totalQuestion, correctanswecount
- for else in seluruh answer nya dan status ny

Learning Finnished

- buat controller learning finish pakai course
- biasa adopsi template
- biasa data data nya disesuai in

Student list, ketika berhasil menambahkan student baru

- COurse)studentCOntroller index, tangkep course
- buat blade di folder student, yakni index.blade.php
- biasa implemen course-student.htmal
- biasa css dan assets
- biasa ubah data course
- di controller, dapatkan pertanyaan, total question, mirip mirp kayak rapoer
- foreacth student, student answers, model StudentAnswers where has query use course, where course id. luar, where user id. get
- answerCount = student answer count
- correctAnswerCOunr = student answor where aswer correct count
- kalau answr count = =
student->status = not started
- else if correct answer < total , status not passed
- else if == , status passed
- lembar question

======================
part 2

- cari student card
- pake in for else dari students
- sesuain aja datanya, ::pakai student->status jangan lupa
- pada add student silakan diganti

==========

registration and login ui

- backup dlu yang lama, pastin yang baru dari template signin
- biasa css dan assets
- form nya method, token, action, samain, termasuk name dari input nya. termasuk tombol
- sama aja buat register