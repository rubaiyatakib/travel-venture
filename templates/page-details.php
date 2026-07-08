<?php
/**
 * Template Name: Details Template
 *
 * @package Travel_Venture
 */

get_header();
?>

<!-- Breadcrumb -->
<?php
$explore_page = get_page_by_path('explore');
$explore_url = $explore_page ? get_permalink($explore_page->ID) : home_url('/explore/');
?>
<div class="bg-slate-100 py-4 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-slate-500 flex items-center space-x-2">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-teal-600 transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-xs"></i>
        <a href="<?php echo esc_url( $explore_url ); ?>" class="hover:text-teal-600 transition-colors">Hotels</a>
        <i class="fa-solid fa-chevron-right text-xs"></i>
        <span id="breadcrumb-title" class="text-slate-800 font-medium truncate">Hotel Name</span>
    </div>
</div>

<!-- Detail Grid Container -->
<main id="detail-page-container" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow w-full">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Left Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Title & Labels -->
            <div class="space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <span id="hotel-detail-location" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-100">
                        <!-- JS drawn -->
                    </span>
                    <span id="hotel-detail-rating" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                        <!-- JS drawn -->
                    </span>
                </div>
                <h1 id="hotel-detail-title" class="text-2xl sm:text-4xl font-semibold font-lato tracking-tight text-slate-900"><!-- JS drawn --></h1>
            </div>

            <!-- Hotel Image Gallery Slider -->
            <div class="rounded-3xl overflow-hidden shadow-md aspect-w-16 h-96 sm:h-128 relative bg-slate-900" id="hotel-gallery-slider">
                <div id="slides-container" class="absolute inset-0">
                    <!-- JS dynamic slides -->
                </div>
                
                <!-- Navigation Buttons -->
                <button type="button" id="prev-slide-btn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-slate-900 bg-opacity-50 hover:bg-opacity-75 text-white w-10 h-10 rounded-full flex items-center justify-center border-none cursor-pointer z-20">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
                <button type="button" id="next-slide-btn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-slate-900 bg-opacity-50 hover:bg-opacity-75 text-white w-10 h-10 rounded-full flex items-center justify-center border-none cursor-pointer z-20">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>

                <!-- Dots Indicators -->
                <div id="slider-dots-container" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                    <!-- JS dynamic dots -->
                </div>
            </div>

            <!-- Description -->
            <div class="prose prose-teal max-w-none space-y-6 text-slate-600 leading-relaxed text-base">
                <h3 class="text-xl font-bold text-slate-950 font-montserrat border-b border-slate-100 pb-2">About The Resort</h3>
                <p id="hotel-detail-description"><!-- JS drawn --></p>
            </div>

            <!-- Video Showcase Block -->
            <div class="space-y-4" id="hotel-video-section">
                <h3 class="text-xl font-bold text-slate-950 font-montserrat border-b border-slate-100 pb-2">Video Showcase</h3>
                <div class="rounded-3xl overflow-hidden shadow-md aspect-w-16 h-96 sm:h-128 relative bg-black" id="video-container">
                    <!-- JS dynamic video frame -->
                </div>
            </div>

            <!-- Amenities -->
            <div class="space-y-4">
                <h3 class="text-xl font-bold text-slate-950 font-montserrat border-b border-slate-100 pb-2">Premium Amenities Included</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" id="hotel-detail-amenities-container">
                    <!-- JS drawn -->
                </div>
            </div>
        </div>

        <!-- Right Card -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 bg-white rounded-3xl p-8 border border-slate-100 shadow-lg space-y-6">
                <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-slate-400 text-xs uppercase tracking-wider block">Exclusive Rate</span>
                        <span id="sidebar-price" class="text-3xl font-extrabold text-slate-900"><!-- JS drawn --></span>
                        <span class="text-slate-500 text-sm">/ night</span>
                    </div>
                    <div class="bg-teal-50 text-teal-700 px-3 py-2 rounded-2xl flex flex-col items-center">
                        <span id="sidebar-rating" class="text-lg font-bold leading-none"><!-- JS drawn --></span>
                        <span class="text-[10px] font-semibold uppercase text-teal-500">Rating</span>
                    </div>
                </div>

                <div class="space-y-4 text-sm text-slate-600">
                    <div class="flex justify-between">
                        <span>Service Fee</span>
                        <span class="font-medium text-slate-900">Included</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Local Tourist Tax</span>
                        <span class="font-medium text-slate-900">Included</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Cancellation Policy</span>
                        <span class="font-medium text-emerald-600">Free cancellation</span>
                    </div>
                </div>

                <!-- Booking Trigger Button -->
                <button type="button" id="details-booking-btn" class="btn-premium w-full px-6 py-4 rounded-full text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 shadow-md text-center inline-block cursor-pointer outline-none border-none transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-calendar-check mr-2"></i> Click for Booking
                </button>

                <div class="text-center pt-2">
                    <span class="text-xs text-slate-400 block"><i class="fa-solid fa-lock text-emerald-500 mr-1"></i> Best Rate Guarantee Secured</span>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Booking Modal -->
<div id="booking-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900 bg-opacity-60 backdrop-filter backdrop-blur-md close-modal-trigger">
    <div class="relative w-full max-w-lg p-8 md:p-10 rounded-3xl glassmorphism text-slate-900 shadow-2xl transition-all duration-300 transform scale-95" onclick="event.stopPropagation();">
        
        <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors close-modal-trigger text-2xl font-bold p-2 focus:outline-none bg-transparent border-none cursor-pointer">
            &times;
        </button>

        <div class="w-16 h-16 mx-auto mb-6 bg-teal-100 rounded-full flex items-center justify-center text-teal-600 text-2xl shadow-inner">
            <i class="fa-solid fa-phone-volume"></i>
        </div>

        <div class="text-center space-y-2 mb-6">
            <span class="text-teal-600 font-semibold tracking-wider text-xs uppercase font-montserrat font-semibold">Direct Concierge Route</span>
            <h3 id="modal-hotel-title" class="text-2xl font-bold font-montserrat tracking-tight">Hotel Title</h3>
        </div>

        <div id="modal-welcome-text" class="text-slate-600 text-sm leading-relaxed mb-8 text-center">
            Loading welcome message...
        </div>

        <div class="space-y-4 text-center">
            <a id="modal-call-btn" href="#" class="pulse-call-btn inline-flex items-center justify-center w-full px-6 py-4 rounded-full text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 shadow-md transform hover:-translate-y-0.5 focus:outline-none">
                <i class="fa-solid fa-phone mr-3 text-lg"></i> Call Reservation Line
            </a>
            
            <p class="text-xs text-slate-400">
                Line: <span id="modal-phone-number-display" class="font-semibold text-slate-600">...</span>
            </p>
        </div>
    </div>
</div>

<!-- Elementor Content Area -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php the_content(); ?>
</div>

<?php
get_footer();
