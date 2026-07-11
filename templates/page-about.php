<?php
/**
 * Template Name: About Page Template
 *
 * @package Travel_Venture
 */

get_header();
?>

<!-- Page Title Hero Section -->
<section class="relative bg-slate-900 text-white overflow-hidden py-16 px-4 sm:px-6 lg:px-8 flex flex-col justify-center items-center text-center">
    <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80');"></div>
    <div class="absolute inset-0 bg-slate-900 bg-opacity-50"></div>
    <div class="relative max-w-4xl mx-auto space-y-4">
        <h1 class="text-4xl sm:text-5xl font-normal tracking-tight font-montserrat leading-none">
            আমাদের <span class="bg-gradient-to-r from-teal-400 to-emerald-300 bg-clip-text text-transparent">উদ্যোগ সম্পর্কে</span>
        </h1>
        <p class="text-base sm:text-lg text-slate-300 max-w-xl mx-auto font-light">
            কক্সবাজারের সেরা জিরো-মার্কআপ ডাইরেক্ট ট্রাভেল পোর্টালের পেছনের গল্প, মান ও মূল্যবোধ জেনে নিন।
        </p>
    </div>
</section>

<!-- Main About Content (Grid Layout) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        
        <div class="space-y-6">
            <span class="text-xs font-semibold tracking-wider uppercase text-teal-600 bg-teal-50 px-3 py-1 rounded-full font-light">আমাদের গল্প</span>
            <h2 class="text-3xl font-normal tracking-tight text-slate-900 font-montserrat">সরাসরি যোগাযোগ। কোনো গোপন চার্জ নেই। আসল আতিথেয়তা।</h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-light">
                TripAzai-এর যাত্রা শুরু হয়েছে একটি সহজ কিন্তু বৈপ্লবিক লক্ষ্য নিয়ে: ভ্রমণকারীরা কোনো অতিরিক্ত কমিশন বা মধ্যস্বত্বভোগীদের বাড়তি খরচ ছাড়াই কক্সবাজারের হোটেলগুলোতে সরাসরি বুকিং করার সুযোগ পাওয়ার যোগ্য। আমরা এমন একটি প্রিমিয়াম প্ল্যাটফর্ম তৈরি করেছি যেখানে অতিথিরা সরাসরি হোটেল অপারেটরদের সাথে যোগাযোগ করে নিজেদের সুবিধাজনক শর্তে ও মূল্যে বুকিং করতে পারেন।
            </p>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-light">
                আপনাকে কক্সবাজারে একটি চমৎকার অভ্যর্থনা জানাতে, TripAzai সম্পূর্ণ বিনামূল্যে আগমনী সকালের নাস্তা এবং আপনার স্টেশন বা বিমানবন্দর থেকে সরাসরি হোটেলের দরজা পর্যন্ত ফ্রি প্রাইভেট শাটল সার্ভিসের ব্যবস্থা করে থাকে—যার জন্য কোনো অতিরিক্ত খরচ দিতে হয় না। আপনার ভ্রমণকে আরও সহজ, আরামদায়ক ও সাশ্রয়ী করতে আমরা প্রতিশ্রুতিবদ্ধ।
            </p>
        </div>
        
        <!-- Large high-quality Unsplash image frame -->
        <div class="rounded-3xl overflow-hidden shadow-lg h-96 relative bg-slate-100">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80" alt="Resort Hotel" class="object-cover w-full h-full">
        </div>
        
    </div>
</section>

<!-- Core Values Grid -->
<section class="bg-slate-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-12">
            <span class="text-xs font-normal tracking-wider uppercase text-teal-600 font-light">আমাদের কাজের মান</span>
            <h2 class="text-3xl font-normal tracking-tight text-slate-900 font-montserrat">আমাদের মূল আদর্শ ও মূল্যবোধ</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-white p-8 rounded-2xl border border-slate-200 border-opacity-70 shadow-sm space-y-4 flex flex-col items-start text-left">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold mb-2">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-normal text-slate-900">সরাসরি যোগাযোগ</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-light">হোটেল অপারেটরদের সাথে সরাসরি যোগাযোগ ও বার্তা আদান-প্রদান করুন। আমরা আপনাকে হোটেলের আসল যোগাযোগের ঠিকানা সরবরাহ করি যাতে কোনো প্রকার তৃতীয় পক্ষের ফি ছাড়াই আপনি বুকিং করতে পারেন।</p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 border-opacity-70 shadow-sm space-y-4 flex flex-col items-start text-left">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold mb-2">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-normal text-slate-900">ফ্রি আগমনী সকালের নাস্তা</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-light">TripAzai-এর মাধ্যমে বুক করা প্রতিটি অতিথি তাঁদের পৌঁছানোর প্রথম সকালে কোনো অতিরিক্ত খরচ ছাড়াই অত্যন্ত সুস্বাদু স্থানীয় নাস্তা উপভোগ করতে পারেন।</p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 border-opacity-70 shadow-sm space-y-4 flex flex-col items-start text-left">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold mb-2">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 11-4 0 2 2 0 014 0zM18 17a2 2 0 11-4 0 2 2 0 014 0zM2 6h14a2 2 0 012 2v8a2 2 0 01-2 2H2V6zM18 13h4M18 9h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-normal text-slate-900">ফ্রি স্টেশন ট্রান্সফার</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-light">কক্সবাজারে পা রাখার মুহূর্ত থেকেই আপনার দুশ্চিন্তাকে বলুন বিদায়। আপনার বাস/ট্রেন স্টেশন বা বিমানবন্দর থেকে সরাসরি আপনার হোটেলের গেট পর্যন্ত আমরা কোনো বাড়তি খরচ ছাড়াই ফ্রি প্রাইভেট শাটল যাতায়াতের ব্যবস্থা করি।</p>
            </div>

        </div>
    </div>
</section>

<!-- Elementor Content Area -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php the_content(); ?>
</div>

<?php
get_footer();
