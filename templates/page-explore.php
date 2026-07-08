<?php
/**
 * Template Name: Explore Template
 *
 * @package Travel_Venture
 */

get_header();
?>

<!-- Header -->
<section class="relative bg-slate-900 text-white py-16 relative overflow-hidden">
    <!-- Hero Background Image (Clear and high contrast) -->
    <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=1600&q=80');"></div>
    <!-- Dark overlay to ensure white text readability -->
    <div class="absolute inset-0 bg-slate-900 bg-opacity-65"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 text-center">
        <h1 class="text-3xl sm:text-5xl font-bold font-montserrat tracking-tight">Hotels</h1>
        <p class="text-slate-300 max-w-lg mx-auto text-sm sm:text-base font-medium">
            Search over 40 exclusive destinations and filter stays by check-in / check-out dates.
        </p>
    </div>
</section>

<!-- Filter Form Panel -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10 w-full hidden">
    <form id="search-filter-form" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
        
        <!-- Keyword -->
        <div class="space-y-1.5">
            <label for="hotel_name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Search Stays</label>
            <div class="relative flex items-center">
                <input type="text" id="hotel_name" placeholder="e.g. Grand Emerald" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all text-slate-800 bg-white" />
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-sm"></i>
            </div>
        </div>

        <!-- Destination Select -->
        <div class="space-y-1.5">
            <label for="location" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Destination</label>
            <div class="relative flex items-center">
                <select id="location" class="w-full pl-10 pr-8 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all appearance-none bg-white text-slate-800">
                    <option value="">Any Destination</option>
                    <option value="Cox's Bazar">Cox's Bazar, Bangladesh</option>
                    <option value="Amalfi Coast">Amalfi Coast</option>
                    <option value="Bali">Bali</option>
                    <option value="Banff">Banff</option>
                    <option value="Barcelona">Barcelona</option>
                    <option value="Big Sur">Big Sur</option>
                    <option value="Bora Bora">Bora Bora</option>
                    <option value="Cairo">Cairo</option>
                    <option value="Cape Town">Cape Town</option>
                    <option value="Chamonix">Chamonix</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Dubrovnik">Dubrovnik</option>
                    <option value="Dubai">Dubai</option>
                    <option value="Galapagos">Galapagos</option>
                    <option value="Iceland">Iceland</option>
                    <option value="Kyoto">Kyoto</option>
                    <option value="Lake Como">Lake Como</option>
                    <option value="Lofoten">Lofoten</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Marrakech">Marrakech</option>
                    <option value="Maui">Maui</option>
                    <option value="Oaxaca">Oaxaca</option>
                    <option value="Oahu">Oahu</option>
                    <option value="Paris">Paris</option>
                    <option value="Patagonia">Patagonia</option>
                    <option value="Petra">Petra</option>
                    <option value="Phuket">Phuket</option>
                    <option value="Queenstown">Queenstown</option>
                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                    <option value="Sardinia">Sardinia</option>
                    <option value="Sedona">Sedona</option>
                    <option value="Serengeti">Serengeti</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Swiss Alps">Swiss Alps</option>
                    <option value="Sydney">Sydney</option>
                    <option value="Tokyo">Tokyo</option>
                    <option value="Tuscany">Tuscany</option>
                    <option value="Venice">Venice</option>
                    <option value="Vienna">Vienna</option>
                    <option value="Whitsundays">Whitsundays</option>
                </select>
                <i class="fa-solid fa-location-dot absolute left-3.5 text-slate-400 text-sm"></i>
                <i class="fa-solid fa-chevron-down absolute right-3.5 text-slate-400 text-xs pointer-events-none"></i>
            </div>
        </div>

        <!-- Check-in -->
        <div class="space-y-1.5">
            <label for="check_in" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Check In</label>
            <div class="date-input-wrapper">
                <input type="text" id="check_in" class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all cursor-pointer text-slate-800 bg-white" readonly />
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>

        <!-- Check-out -->
        <div class="space-y-1.5">
            <label for="check_out" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Check Out</label>
            <div class="date-input-wrapper">
                <input type="text" id="check_out" class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all cursor-pointer text-slate-800 bg-white" readonly />
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>

        <!-- Button -->
        <div>
            <button type="submit" class="w-full py-3.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 shadow-md transition-all flex items-center justify-center space-x-2 border-none cursor-pointer transform hover:-translate-y-0.5">
                <i class="fa-solid fa-filter text-xs"></i> <span>Apply Filters</span>
            </button>
        </div>

    </form>
</section>

<!-- Listings Grid -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full flex-grow">
    
    <!-- Active Criteria Pills -->
    <div id="active-criteria-pills" class="mb-8 flex flex-wrap items-center gap-2 text-xs font-medium text-slate-600 hidden">
        <!-- Dynamically Drawn -->
    </div>

    <!-- Cards Container -->
    <div id="hotels-list-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Rendered by JS -->
    </div>

</main>

<!-- Elementor Content Area -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php the_content(); ?>
</div>

<?php
get_footer();
