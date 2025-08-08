<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;

class SendDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report of new users and posts to admin email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $newUsers = User::whereDate('created_at', today())->count();
        $newPosts = Post::whereDate('created_at', today())->count();
        $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL', 'admin@taskera.com'));

        $body = "تقرير يومي:\nعدد المستخدمين الجدد اليوم: $newUsers\nعدد المنشورات الجديدة اليوم: $newPosts";

        Mail::raw($body, function ($message) use ($adminEmail) {
            $message->to($adminEmail)->subject('تقرير يومي');
        });

        $this->info('تم إرسال التقرير اليومي بنجاح إلى: ' . $adminEmail);
    }
}
