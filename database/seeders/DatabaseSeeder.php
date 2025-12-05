<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Tags first
        $tags = [
            'Laravel',
            'PHP',
            'JavaScript',
            'Database',
            'API',
            'Authentication',
            'Eloquent',
            'Blade',
            'Tailwind CSS',
            'Vue.js',
        ];

        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }

        // Create users with different reputation levels
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'reputation' => 150, // Can create tags and edit others' questions
        ]);

        $expert = User::factory()->create([
            'name' => 'Expert User',
            'email' => 'expert@example.com',
            'password' => bcrypt('password'),
            'reputation' => 80,
        ]);

        $intermediate = User::factory()->create([
            'name' => 'Intermediate User',
            'email' => 'intermediate@example.com',
            'password' => bcrypt('password'),
            'reputation' => 30,
        ]);

        $beginner = User::factory()->create([
            'name' => 'Beginner User',
            'email' => 'beginner@example.com',
            'password' => bcrypt('password'),
            'reputation' => 5,
        ]);

        // Create some questions with answers
        
        // Question 1: Laravel Routes
        $question1 = Question::create([
            'user_id' => $beginner->id,
            'title' => 'Làm thế nào để tạo route với parameter trong Laravel?',
            'content' => 'Tôi muốn tạo một route có thể nhận parameter từ URL. Ví dụ `/users/{id}`. Làm thế nào để implement điều này trong Laravel?

```php
// routes/web.php
Route::get(\'/users/{id}\', ...);
```

Tôi đã thử như trên nhưng không biết cách nhận parameter trong Controller.',
            'views' => 45,
        ]);
        $question1->tags()->attach(Tag::where('name', 'Laravel')->first()->id);
        $question1->tags()->attach(Tag::where('name', 'PHP')->first()->id);

        $answer1a = Answer::create([
            'user_id' => $expert->id,
            'question_id' => $question1->id,
            'content' => 'Bạn có thể nhận parameter trong Controller như sau:

```php
public function show($id)
{
    $user = User::findOrFail($id);
    return view(\'users.show\', compact(\'user\'));
}
```

Laravel sẽ tự động inject parameter vào method của bạn.',
            'is_best' => true,
        ]);

        Answer::create([
            'user_id' => $admin->id,
            'question_id' => $question1->id,
            'content' => 'Ngoài cách trên, bạn cũng có thể sử dụng Route Model Binding:

```php
Route::get(\'/users/{user}\', [UserController::class, \'show\']);

// Controller
public function show(User $user)
{
    return view(\'users.show\', compact(\'user\'));
}
```

Laravel sẽ tự động query model User theo ID.',
        ]);

        // Question 2: Database Query
        $question2 = Question::create([
            'user_id' => $intermediate->id,
            'title' => 'Cách optimize database query trong Laravel?',
            'content' => 'Dự án của tôi có vấn đề về performance khi load danh sách bài viết với nhiều relationships. Mỗi bài viết có author, tags, và comments. Làm thế nào để optimize?',
            'views' => 78,
        ]);
        $question2->tags()->attach([
            Tag::where('name', 'Laravel')->first()->id,
            Tag::where('name', 'Database')->first()->id,
            Tag::where('name', 'Eloquent')->first()->id,
        ]);

        Answer::create([
            'user_id' => $admin->id,
            'question_id' => $question2->id,
            'content' => 'Sử dụng **Eager Loading** để tránh N+1 query problem:

```php
$posts = Post::with([\'author\', \'tags\', \'comments\'])
    ->paginate(15);
```

Thay vì query từng relationship riêng lẻ, Laravel sẽ chỉ thực hiện vài queries tổng hợp.',
            'is_best' => true,
        ]);

        // Question 3: Authentication
        $question3 = Question::create([
            'user_id' => $beginner->id,
            'title' => 'Laravel Breeze vs Laravel Sanctum - Nên chọn cái nào?',
            'content' => 'Tôi đang học Laravel và thấy có nhiều package cho authentication: Breeze, Sanctum, Passport. Sự khác biệt là gì và khi nào nên dùng package nào?',
            'views' => 92,
        ]);
        $question3->tags()->attach([
            Tag::where('name', 'Laravel')->first()->id,
            Tag::where('name', 'Authentication')->first()->id,
        ]);

        Answer::create([
            'user_id' => $expert->id,
            'question_id' => $question3->id,
            'content' => '**Laravel Breeze**: Dùng cho web app truyền thống với session-based auth. Rất đơn giản và nhẹ.

**Laravel Sanctum**: Dùng cho API và SPA. Hỗ trợ token-based authentication.

**Laravel Passport**: Dùng cho OAuth2 server, phức tạp hơn, phù hợp với large-scale applications.

Nếu bạn mới học, hãy bắt đầu với **Breeze**!',
        ]);

        Answer::create([
            'user_id' => $admin->id,
            'question_id' => $question3->id,
            'content' => 'Tôi đồng ý! Thêm một lưu ý:

- **Breeze**: Web app (blade templates, session)
- **Sanctum**: Mobile app, SPA (React, Vue)
- **Passport**: OAuth2 provider (như Google, Facebook login)

Chọn dựa trên kiến trúc ứng dụng của bạn.',
        ]);

        // Question 4: JavaScript/Tailwind
        $question4 = Question::create([
            'user_id' => $intermediate->id,
            'title' => 'Cách tích hợp Alpine.js với Blade templates?',
            'content' => 'Tôi muốn thêm tính năng interactive cho Blade templates mà không cần build step phức tạp. Alpine.js có phù hợp không? Làm thế nào để bắt đầu?',
            'views' => 34,
        ]);
        $question4->tags()->attach([
            Tag::where('name', 'JavaScript')->first()->id,
            Tag::where('name', 'Blade')->first()->id,
        ]);

        Answer::create([
            'user_id' => $admin->id,
            'question_id' => $question4->id,
            'content' => 'Alpine.js là lựa chọn tuyệt vời cho Blade! Chỉ cần thêm CDN:

```html
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

Sau đó dùng directives như `x-data`, `x-show`, `x-on`:

```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content here</div>
</div>
```

Rất đơn giản và mạnh mẽ!',
            'is_best' => true,
        ]);

        // Question 5: Tailwind CSS
        $question5 = Question::create([
            'user_id' => $beginner->id,
            'title' => 'Tailwind CSS có đáng học không?',
            'content' => 'Tôi đang tự học web development và thấy nhiều người nói về Tailwind CSS. Class names rất dài và khó nhớ. Có thực sự đáng để học không? Ưu điểm là gì?',
            'views' => 156,
        ]);
        $question5->tags()->attach([
            Tag::where('name', 'Tailwind CSS')->first()->id,
        ]);

        Answer::create([
            'user_id' => $expert->id,
            'question_id' => $question5->id,
            'content' => '**Đáng học!** Ưu điểm:

1. **Nhanh hơn**: Không cần chuyển qua lại giữa HTML và CSS
2. **Consistent**: Design system built-in
3. **File size nhỏ**: Chỉ build những class đang dùng
4. **Dễ maintain**: Mọi thứ trong 1 file
5. **Không lo conflict**: Không có global CSS

Ban đầu khó khăn vì nhiều class, nhưng sau 1 tuần sẽ quen!',
        ]);

        Answer::create([
            'user_id' => $admin->id,
            'question_id' => $question5->id,
            'content' => 'Thêm một tip: Dùng Tailwind IntelliSense extension trong VS Code, nó sẽ gợi ý class và show preview. Giúp học nhanh hơn rất nhiều!',
            'is_best' => true,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@example.com / password (150 điểm)');
        $this->command->info('Expert: expert@example.com / password (80 điểm)');
        $this->command->info('Intermediate: intermediate@example.com / password (30 điểm)');
        $this->command->info('Beginner: beginner@example.com / password (5 điểm)');
    }
}