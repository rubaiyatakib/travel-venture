<?php
/**
 * The header template
 *
 * @package Travel_Venture
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <!-- FontAwesome 6 Icons (Direct CDN to guarantee loading) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php wp_head(); ?>
    
    <style id="tripazai-customizer-css">
        :root {
            --primary-color: <?php echo esc_attr( get_theme_mod( 'primary_color', '#1e293b' ) ); ?>;
            --secondary-color: <?php echo esc_attr( get_theme_mod( 'secondary_color', '#d97706' ) ); ?>;
            --bg-color: <?php echo esc_attr( get_theme_mod( 'background_color', '#f8fafc' ) ); ?>;
            --font-headings: "<?php echo esc_attr( get_theme_mod( 'headings_font', 'Outfit' ) ); ?>", sans-serif;
            --font-body: "<?php echo esc_attr( get_theme_mod( 'body_font', 'Inter' ) ); ?>", sans-serif;
        }
        body {
            background-color: var(--bg-color);
            font-family: var(--font-body);
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-headings);
        }
    </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <header class="sticky top-0 z-50 bg-white bg-opacity-80 backdrop-filter backdrop-blur-lg border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center py-1">
                        <?php
                        if ( has_custom_logo() ) {
                            $logo_img = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
                            echo '<img src="' . esc_url( $logo_img[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="h-12 w-auto object-contain" />';
                        } else {
                            $logo_path = get_template_directory() . '/logo.jpg';
                            if ( file_exists( $logo_path ) ) {
                                echo '<img src="' . esc_url( get_template_directory_uri() . '/logo.jpg' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="h-12 w-auto object-contain" />';
                            } else {
                                echo '<span class="text-xl font-extrabold tracking-tight text-slate-900 font-montserrat">Trip<span class="text-teal-600">Azai</span></span>';
                            }
                        }
                        ?>
                    </a>
                </div>
                <?php
                $about_page = get_page_by_path('about');
                $explore_page = get_page_by_path('explore');
                $about_url = $about_page ? get_permalink($about_page->ID) : home_url('/about/');
                $explore_url = $explore_page ? get_permalink($explore_page->ID) : home_url('/explore/');
                ?>
                <nav class="hidden md:flex space-x-8 items-center text-sm font-semibold text-slate-600">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-teal-600 transition-colors">Home</a>
                    <a href="<?php echo esc_url( $explore_url ); ?>" class="hover:text-teal-600 transition-colors">Hotels</a>
                    <a href="<?php echo esc_url( $about_url ); ?>" class="hover:text-teal-600 transition-colors">About Us</a>
                    <a href="<?php echo esc_url( $explore_url ); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 transition-all duration-300">
                        Find a Room
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" id="mobile-menu-toggle" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none bg-transparent border-none cursor-pointer">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path class="inline-flex" id="menu-icon-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path class="hidden" id="menu-icon-close" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Container -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 shadow-lg transition-all duration-300">
            <div class="px-4 pt-2 pb-6 space-y-2 text-center flex flex-col font-semibold text-slate-600 text-base">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block px-3 py-2.5 rounded-md hover:bg-slate-50 hover:text-teal-600 transition-colors">Home</a>
                <a href="<?php echo esc_url( $explore_url ); ?>" class="block px-3 py-2.5 rounded-md hover:bg-slate-50 hover:text-teal-600 transition-colors">Hotels</a>
                <a href="<?php echo esc_url( $about_url ); ?>" class="block px-3 py-2.5 rounded-md hover:bg-slate-50 hover:text-teal-600 transition-colors">About Us</a>
                <a href="<?php echo esc_url( $explore_url ); ?>" class="block px-4 py-3 rounded-full text-center text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 transition-all font-bold">
                    Find a Room
                </a>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toggleBtn = document.getElementById('mobile-menu-toggle');
                var mobileMenu = document.getElementById('mobile-menu');
                var openIcon = document.getElementById('menu-icon-open');
                var closeIcon = document.getElementById('menu-icon-close');

                if (toggleBtn && mobileMenu) {
                    toggleBtn.addEventListener('click', function() {
                        var isHidden = mobileMenu.classList.contains('hidden');
                        if (isHidden) {
                            mobileMenu.classList.remove('hidden');
                            openIcon.classList.add('hidden');
                            closeIcon.classList.remove('hidden');
                        } else {
                            mobileMenu.classList.add('hidden');
                            openIcon.classList.remove('hidden');
                            closeIcon.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </header>

