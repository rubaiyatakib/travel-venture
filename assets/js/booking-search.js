/**
 * TripAzai Preview Mockup Script
 * Simulates WordPress and Elementor dynamics on the front-end
 */

// Simulated Hotel Database (41 Hotels matching WordPress auto-seed list)
const hotelsDb = [
    {
        id: 0,
        title: 'The Grand Emerald Lagoon Resort',
        description: 'Nestled in the pristine waters of the Maldives, this luxury resort features overwater villas, a world-class underwater restaurant, and infinity pools that merge seamlessly with the crystal-clear ocean. Wake up to panoramic sunrise views and experience pure tropical paradise.',
        phone: '+1-800-555-0101',
        location: 'Maldives',
        price: '850',
        rating: '5.0',
        image: 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
        unavail: ['2026-07-10,2026-07-15', '2026-08-01,2026-08-07']
    },
    {
        id: 1,
        title: 'Sanctuary Valley Oasis',
        description: 'Immerse yourself in Bali\'s lush emerald jungle. The Sanctuary Valley Oasis features infinity pools hanging over ravines, open-air stone baths, and traditional wood villas. A dedicated holistic wellness spa offers daily yoga overlooking the sacred river.',
        phone: '+1-800-555-0102',
        location: 'Bali',
        price: '320',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80',
        unavail: ['2026-07-20,2026-07-25']
    },
    {
        id: 2,
        title: 'Caldera Horizon Suites',
        description: 'Perched high on the cliffs of Oia in Santorini, Caldera Horizon Suites features white-washed dome architectures and private heated cave pools. Gaze out at the legendary Aegean sunsets from your private veranda, with local volcanic wines served at twilight.',
        phone: '+1-800-555-0103',
        location: 'Santorini',
        price: '650',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80',
        unavail: ['2026-09-01,2026-09-10']
    },
    {
        id: 3,
        title: 'Summit Ridge Chalet & Lodge',
        description: 'A cozy mountain retreat situated in the heart of the Swiss Alps. Enjoy wood-burning stone fireplaces, ski-in/ski-out access, and a thermal outdoor jacuzzi overlooking the snow-covered peak of the Matterhorn. Pure alpine luxury.',
        phone: '+1-800-555-0104',
        location: 'Swiss Alps',
        price: '490',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1502784444187-359ac186c5bb?auto=format&fit=crop&w=800&q=80',
        unavail: ['2026-12-20,2027-01-05']
    },
    {
        id: 4,
        title: 'Momiji Ryokan & Onsen Spa',
        description: 'A peaceful sanctuary in historic Kyoto. This luxury ryokan provides tatami rooms, private cypress wood bathtubs, and multi-course Kaiseki dinners. Walk through tranquil maple gardens and experience Zen meditation guided by local masters.',
        phone: '+1-800-555-0105',
        location: 'Kyoto',
        price: '410',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 5,
        title: 'Atlantic Crest Ocean Manor',
        description: 'Overlooking the dramatic cliffs where the mountains meet the sea in Cape Town. Features private penthouse terraces, custom wine tastings from the Cape Winelands, and immediate access to pristine sandy beaches. Modern architecture at its finest.',
        phone: '+1-800-555-0106',
        location: 'Cape Town',
        price: '280',
        rating: '4.6',
        image: 'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 6,
        title: 'Southern Lakes Alpine Lodge',
        description: 'Located on the shores of Lake Wakatipu in Queenstown, New Zealand. Ideal for adventure seekers and luxury travelers alike. Offers private helicopter charters to Milford Sound, ski rentals, and gourmet fireside dining with panoramic lake views.',
        phone: '+1-800-555-0107',
        location: 'Queenstown',
        price: '350',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1475924156734-496f6cac6ec1?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 7,
        title: 'Lagoon Whispers Overwater Villa',
        description: 'A premier Bora Bora getaway set on a private turquoise lagoon. Wake up to direct steps into the warm ocean water. Includes glass floor panels to watch marine life, private catamarans, and exceptional Polynesian fine dining.',
        phone: '+1-800-555-0108',
        location: 'Bora Bora',
        price: '980',
        rating: '5.0',
        image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
        unavail: ['2026-07-01,2026-07-08']
    },
    {
        id: 8,
        title: 'Positano Cliff House',
        description: 'Carved into the towering rocky cliffs of the Amalfi Coast. Features hand-painted tiling, jasmine-draped balconies, and a panoramic restaurant overlooking Positano Bay. Enjoy direct elevator access to a private beach cove.',
        phone: '+1-800-555-0109',
        location: 'Amalfi Coast',
        price: '720',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 9,
        title: 'L\'Avenue Royale Boutique',
        description: 'A charming boutique hotel situated just steps from the Champs-Élysées. Combining classic French moldings with contemporary art. Indulge in warm croissants, fresh espresso, and bespoke concierge services in the City of Lights.',
        phone: '+1-800-555-0110',
        location: 'Paris',
        price: '550',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 10,
        title: 'Neon Skyline Tower',
        description: 'Soaring high above the pulsing streets of Shinjuku, Tokyo. Offers floor-to-ceiling windows with jaw-dropping views of Mount Fuji on clear days, a Michelin-starred sushi bar, and a state-of-the-art rooftop pool.',
        phone: '+1-800-555-0111',
        location: 'Tokyo',
        price: '450',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 11,
        title: 'Wailea Coast Retreat',
        description: 'A luxury Hawaiian resort situated along the gold sands of Maui. Surrounded by tropical gardens, waterfalls, and championship golf courses. Includes oceanfront dining, double-lounger cabanas, and local craft cocktail lounges.',
        phone: '+1-800-555-0112',
        location: 'Maui',
        price: '620',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 12,
        title: 'Aurora Glass Domes',
        description: 'A surreal experience in the volcanic landscapes of Iceland. Sleep under a glass dome that gives you a front-row seat to the magical Northern Lights. Includes private geothermal hot tubs and guided glacier treks.',
        phone: '+1-800-555-0113',
        location: 'Iceland',
        price: '590',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1528164344705-47542687000d?auto=format&fit=crop&w=800&q=80',
        unavail: ['2026-10-15,2026-10-25']
    },
    {
        id: 13,
        title: 'Golden Dunes Luxury Palace',
        description: 'An oasis of luxury rise in the deserts of Dubai. Features gold-plated interiors, personal butler service, indoor ski slope partnerships, and private desert safari drives. Experience royal Arabian hospitality.',
        phone: '+1-800-555-0114',
        location: 'Dubai',
        price: '950',
        rating: '5.0',
        image: 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 14,
        title: 'Andaman Azure Resort',
        description: 'Overlooking the emerald green waters of Phuket. A premium beachfront resort boasting infinity pools, a Thai-massage temple, and luxury private yachts available for island hopping in Phang Nga Bay.',
        phone: '+1-800-555-0115',
        location: 'Phuket',
        price: '240',
        rating: '4.6',
        image: 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 15,
        title: 'Rockies Pine Lodge',
        description: 'Surrounded by pine-forested peaks in Banff National Park. Cozy log cabins decorated with rustic elegance. Features private balconies, hot cocoa around outdoor bonfires, and immediate trails leading to Lake Louise.',
        phone: '+1-800-555-0116',
        location: 'Banff',
        price: '380',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 16,
        title: 'Copacabana Breeze Hotel',
        description: 'Soak up the vibrant energy of Rio de Janeiro. Located right on the Copacabana shoreline, featuring a lively rooftop bar, samba lesson packages, and rooms with unobstructed sea views.',
        phone: '+1-800-555-0117',
        location: 'Rio de Janeiro',
        price: '210',
        rating: '4.5',
        image: 'https://images.unsplash.com/photo-1483728642387-6c3bdd6c93e5?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 17,
        title: 'Acacia Wilderness Camp',
        description: 'A luxury tented lodge in the heart of the Serengeti. Wake up to elephant herds migrating, enjoy gourmet dinners under the starry African sky, and take part in daily professional-guided game drives.',
        phone: '+1-800-555-0118',
        location: 'Serengeti',
        price: '800',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=800&q=80',
        unavail: ['2026-08-10,2026-08-20']
    },
    {
        id: 18,
        title: 'Red Rock Canyons Wellness',
        description: 'A wellness retreat built into the ancient red rocks of Sedona. Offers guided vortex hikes, stone massage spas, and stargazing balconies with zero light pollution. Rejuvenate your body and spirit.',
        phone: '+1-800-555-0119',
        location: 'Sedona',
        price: '340',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 19,
        title: 'Gothic Quarter Boutique',
        description: 'Steps from Barcelona Cathedral. Features exposed medieval stone walls blended with state-of-the-art designer furniture. Enjoy local tapas and sangria on a private rooftop pool terrace.',
        phone: '+1-800-555-0120',
        location: 'Barcelona',
        price: '290',
        rating: '4.6',
        image: 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 20,
        title: 'Treetop Rainforest Eco-Resort',
        description: 'Eco-friendly luxury in Costa Rica\'s cloud forest canopy. Sleep in modern wooden structures elevated high above the forest floor. Ziplining, monkey spotting, and organic farm-to-table cuisine included.',
        phone: '+1-800-555-0121',
        location: 'Costa Rica',
        price: '270',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 21,
        title: 'Yacht Club Vista',
        description: 'A stunning luxury resort on the shores of Costa Smeralda, Sardinia. Offers private yacht docks, crystal-clear water viewpoints, and premium Mediterranean seafood dining on an open terrace.',
        phone: '+1-800-555-0122',
        location: 'Sardinia',
        price: '780',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 22,
        title: 'Mont Blanc Glacier Lodge',
        description: 'Located in Chamonix, France, with front-row seats to the majestic Mont Blanc. Offers high-end heated ski gear lockups, a luxury spa with glacier water treatments, and fine French alpine cuisine.',
        phone: '+1-800-555-0123',
        location: 'Chamonix',
        price: '480',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1454496522488-7a8e488e8606?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 23,
        title: 'Villa Oliveto Estates',
        description: 'A restored 16th-century stone estate in Tuscany. Stroll through cypress-lined driveways, take cooking classes with local Italian chefs, and taste organic Chianti wine harvested from the property.',
        phone: '+1-800-555-0124',
        location: 'Tuscany',
        price: '390',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1508849789987-4e5333c12b78?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 24,
        title: 'Desert Rose Bedouin Camp',
        description: 'An immersive, high-end glamping camp located just outside the archaeological wonders of Petra, Jordan. Sleep in luxurious stargazing domes and enjoy traditional Bedouin music and roasted lamb around a campfire.',
        phone: '+1-800-555-0125',
        location: 'Petra',
        price: '190',
        rating: '4.6',
        image: 'https://images.unsplash.com/photo-1541432901042-2d8bd64b4a9b?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 25,
        title: 'Ocean Voyager Eco-Lodge',
        description: 'A conservation-first luxury lodge in the Galapagos Islands. Swim with sea lions, giant tortoises, and marine iguanas just off the private dock. Daily naturalists-led land and sea excursions included.',
        phone: '+1-800-555-0126',
        location: 'Galapagos',
        price: '450',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1452421820064-e70a9844130e?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 26,
        title: 'Midnight Sun Fishing Cabins',
        description: 'Beautifully renovated historical red fishing cabins (rorbuer) in Lofoten, Norway. Suspended over the cold, clear sea, backdropped by jagged granite peaks. View the midnight sun in summer or auroras in winter.',
        phone: '+1-800-555-0127',
        location: 'Lofoten',
        price: '230',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1527004013197-933c4bb611b3?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 27,
        title: 'Coral Cove Secret Resort',
        description: 'An exclusive private island feel in the Seychelles. Framed by iconic giant granite boulders and leaning palms. Enjoy private infinity pools, marine safaris, and Creole-infused beachside barbecues.',
        phone: '+1-800-555-0128',
        location: 'Seychelles',
        price: '920',
        rating: '5.0',
        image: 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=800&q=80',
        unavail: ['2026-07-05,2026-07-12']
    },
    {
        id: 28,
        title: 'Villa Bellagio Heritage',
        description: 'A historic luxury villa positioned on the water\'s edge of Lake Como, Italy. Features ornate frescoed ceilings, private speedboats, manicured Italian gardens, and fine lakeside dining.',
        phone: '+1-800-555-0129',
        location: 'Lake Como',
        price: '880',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 29,
        title: 'Casa Ancestral Zapotec',
        description: 'A boutique designer hotel in Oaxaca, Mexico. Centered around a tranquil open courtyard, featuring local woven textiles, mezcal tasting bars, and molecular Oaxacan tasting menus.',
        phone: '+1-800-555-0130',
        location: 'Oaxaca',
        price: '150',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1512813583145-ac554ac82e4a?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 30,
        title: 'Glacier Edge Eco-Yurts',
        description: 'Positioned at the edge of Torres del Paine in Patagonia. High-end modern dome structures with glass ceilings to watch the southern stars, heated wood floors, and guided mountaineering tracks.',
        phone: '+1-800-555-0131',
        location: 'Patagonia',
        price: '510',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1513407030348-c983a97b98d8?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 31,
        title: 'Nile Pharaoh Palace',
        description: 'A grand luxury hotel in Cairo, offering sweeping views of the historic Nile River and the Great Pyramids of Giza. Features an expansive pool deck, marble colonnades, and traditional Egyptian spa treatments.',
        phone: '+1-800-555-0132',
        location: 'Cairo',
        price: '310',
        rating: '4.6',
        image: 'https://images.unsplash.com/photo-1539650116574-8efeb43e2750?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 32,
        title: 'Pacific Redwood Retreat',
        description: 'Hidden amongst the ancient coastal redwoods of Big Sur, California. Elevated cabins with private outdoor copper tubs, roaring fireplaces, and viewing decks pointing at the crashing Pacific waves below.',
        phone: '+1-800-555-0133',
        location: 'Big Sur',
        price: '570',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 33,
        title: 'Grand Canal Gondola Palace',
        description: 'A majestic 15th-century Venetian palazzo on the Grand Canal. Boasts Murano glass chandeliers, velvet furnishings, private water-taxi landings, and romantic candlelit terrace dinners.',
        phone: '+1-800-555-0134',
        location: 'Venice',
        price: '690',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1527631746610-bca00a040d60?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 34,
        title: 'Riad Jasmine Gardens',
        description: 'A quiet haven inside the bustling Medina of Marrakech. An emerald-tiled swimming pool surrounded by orange trees and lanterns. Enjoy homemade mint tea, tagine cooking, and traditional hammam services.',
        phone: '+1-800-555-0135',
        location: 'Marrakech',
        price: '260',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1539650116574-8efeb43e2750?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 35,
        title: 'Whitehaven Sands Resort',
        description: 'A premium tropical resort on the Whitsunday Islands, Australia. Immediate access to the swirls of silica sands. Snorkel the Great Barrier Reef, take helicopter tours, or relax in our beachside daybeds.',
        phone: '+1-800-555-0136',
        location: 'Whitsundays',
        price: '740',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 36,
        title: 'Diamond Head Surf Lodge',
        description: 'A boutique beach lodge in Oahu, Hawaii, located right on the famous surf breaks. Features outdoor surfboard showers, fresh local poke bowls, beachside live music, and private surf guides.',
        phone: '+1-800-555-0137',
        location: 'Oahu',
        price: '330',
        rating: '4.6',
        image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 37,
        title: 'Imperial Opera Grand',
        description: 'A legendary historical hotel in the heart of Vienna, Austria. Featuring classical architecture, high ceilings, gilded trim, a historic cafe serving Sachertorte, and opera-ticket priority booking.',
        phone: '+1-800-555-0138',
        location: 'Vienna',
        price: '420',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 38,
        title: 'Old Town City Wall Retreat',
        description: 'Set directly within the medieval stone walls of Dubrovnik, Croatia. Look out over the terracotta roof tiles and the shimmering Adriatic Sea. Includes private boat tours to nearby islands.',
        phone: '+1-800-555-0139',
        location: 'Dubrovnik',
        price: '310',
        rating: '4.7',
        image: 'https://images.unsplash.com/photo-1555992336-03a23c7b20eb?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 39,
        title: 'Harbour Bridge Vista Suites',
        description: 'Overlooking the iconic Sydney Harbour Bridge and Opera House. A modern luxury tower featuring floor-to-ceiling windows, private balconies, a rooftop cocktail lounge, and harbor ferry services.',
        phone: '+1-800-555-0140',
        location: 'Sydney',
        price: '460',
        rating: '4.8',
        image: 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80',
        unavail: []
    },
    {
        id: 40,
        title: 'Chalet Bellecote Luxury Chalet',
        description: 'A stunning modern ski chalet situated in Verbier, Swiss Alps. Features exposed wooden timbers, sheepskin throw blankets, a private wine cellar, ski valets, and a private chef preparing custom dinners.',
        phone: '+1-800-555-0141',
        location: 'Swiss Alps',
        price: '920',
        rating: '4.9',
        image: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80',
        unavail: []
    }
];

// Post-process hotelsDb to add dynamic 6-image gallery and video link for each hotel
hotelsDb.forEach((h, index) => {
    if (!h.gallery) {
        h.gallery = [
            h.image,
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=800&q=80'
        ];
    }
    if (!h.video) {
        const videos = [
            'https://www.youtube.com/watch?v=ScXs7L0fVk0',
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://www.youtube.com/watch?v=ScXs7L0fVk0'
        ];
        h.video = videos[index % videos.length];
    }
});

// Explorer / Search page controller
function initExplorer() {
    const listContainer = document.getElementById('hotels-list-grid');
    if (!listContainer) return;

    const form = document.getElementById('search-filter-form');
    const hotelNameInput = document.getElementById('hotel_name');
    const locationSelect = document.getElementById('location');
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const criteriaContainer = document.getElementById('active-criteria-pills');

    // Read initial URL params
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('hotel_name')) hotelNameInput.value = urlParams.get('hotel_name');
    if (urlParams.get('location')) locationSelect.value = urlParams.get('location');
    if (urlParams.get('check_in')) checkInInput.value = urlParams.get('check_in');
    if (urlParams.get('check_out')) checkOutInput.value = urlParams.get('check_out');

    // Apply filtering
    function renderFilteredHotels() {
        const queryName = hotelNameInput.value.toLowerCase().trim();
        const queryLoc = locationSelect.value;
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;

        // Render active criteria list
        let pillsHtml = '';
        if (queryName) pillsHtml += `<span class="bg-slate-200 px-3 py-1 rounded-full">Name: "${queryName}"</span>`;
        if (queryLoc) pillsHtml += `<span class="bg-slate-200 px-3 py-1 rounded-full">Region: ${queryLoc}</span>`;
        if (checkIn && checkOut) pillsHtml += `<span class="bg-slate-200 px-3 py-1 rounded-full">Dates: ${checkIn} to ${checkOut}</span>`;
        
        if (pillsHtml) {
            const clearUrl = (typeof travelVentureData !== 'undefined' && travelVentureData.explore_url) ? travelVentureData.explore_url : 'explore.html';
            criteriaContainer.innerHTML = `<span class="text-slate-400">Active Criteria:</span> ${pillsHtml} <a href="${clearUrl}" class="text-teal-600 hover:underline text-xs ml-2">Clear all</a>`;
            criteriaContainer.classList.remove('hidden');
        } else {
            criteriaContainer.classList.add('hidden');
            criteriaContainer.innerHTML = '';
        }

        const filtered = hotelsDb.filter(h => {
            // Filter by name
            if (queryName && !h.title.toLowerCase().includes(queryName)) {
                return false;
            }

            // Filter by location
            if (queryLoc && h.location !== queryLoc) {
                return false;
            }

            // Filter by unavailable date range overlaps
            if (checkIn && checkOut) {
                const reqIn = new Date(checkIn).getTime();
                const reqOut = new Date(checkOut).getTime();

                if (!isNaN(reqIn) && !isNaN(reqOut) && reqOut >= reqIn) {
                    for (let range of h.unavail) {
                        const parts = range.split(',');
                        if (parts.length === 2) {
                            const unIn = new Date(parts[0].trim()).getTime();
                            const unOut = new Date(parts[1].trim()).getTime();

                            if (reqIn <= unOut && reqOut >= unIn) {
                                return false; // Overlap detected, hotel occupied
                            }
                        }
                    }
                }
            }

            return true;
        });

        // Clear and draw grid
        listContainer.innerHTML = '';
        
        if (filtered.length === 0) {
            listContainer.outerHTML = `
                <div id="hotels-list-grid" class="col-span-3 text-center py-12 space-y-3 bg-white border border-slate-100 rounded-3xl shadow-inner p-8">
                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-400 text-2xl">
                        <i class="fa-solid fa-hotel"></i>
                    </div>
                    <h3 class="text-lg font-bold">No Available Stays Found</h3>
                    <p class="text-slate-500 text-sm max-w-sm mx-auto">No hotels match your filters or are available during your selected dates.</p>
                </div>`;
            return;
        }

        // Render card layouts
        filtered.forEach(h => {
            const baseUrl = (typeof travelVentureData !== 'undefined' && travelVentureData.details_url) ? travelVentureData.details_url : 'details.html';
            let detailLink = baseUrl + (baseUrl.includes('?') ? '&' : '?') + `hotel_id=${h.id}`;
            if (checkIn && checkOut) {
                detailLink += `&check_in=${encodeURIComponent(checkIn)}&check_out=${encodeURIComponent(checkOut)}`;
            }

            const card = document.createElement('div');
            card.className = "bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-slate-100 flex flex-col h-full group";
            card.innerHTML = `
                <div class="relative overflow-hidden aspect-w-16 h-60">
                    <img src="${h.image}" alt="${h.title}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4 bg-slate-900 bg-opacity-75 backdrop-filter backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                        <i class="fa-solid fa-location-dot mr-1.5 text-teal-400"></i> ${h.location}
                    </div>
                    <div class="absolute top-4 right-4 bg-white text-amber-600 px-3 py-1 rounded-full text-xs font-bold flex items-center shadow-sm">
                        <i class="fa-solid fa-star mr-1"></i> ${h.rating}
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow space-y-4">
                    <div class="h-14 overflow-hidden flex flex-col justify-center">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition-colors line-clamp-2 leading-snug">
                            <a href="${detailLink}">${h.title}</a>
                        </h3>
                    </div>
                    <div class="h-16 overflow-hidden">
                        <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed">
                            ${h.description}
                        </p>
                    </div>
                    <div class="border-t border-slate-100 pt-4 mt-auto flex justify-between items-center">
                        <div class="text-slate-500 text-sm">
                            Rates from <span class="text-2xl font-extrabold text-slate-950 block sm:inline">$${h.price}</span>
                        </div>
                        <a href="${detailLink}" class="btn-premium inline-flex items-center px-4 py-2.5 rounded-full text-xs font-semibold text-white bg-slate-900 hover:bg-teal-700 transition-colors">
                            Explore Stays <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                        </a>
                    </div>
                </div>`;
            listContainer.appendChild(card);
        });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        renderFilteredHotels();
    });

    // Run first render
    renderFilteredHotels();
}

// Hotel Details Page Controller
function initDetails() {
    const detailContainer = document.getElementById('detail-page-container');
    if (!detailContainer) return;

    const currencySymbol = (typeof travelVentureData !== 'undefined' && travelVentureData.currency_symbol) ? travelVentureData.currency_symbol : '$';

    // Retrieve Hotel ID from URL query
    const urlParams = new URLSearchParams(window.location.search);
    const hotelId = parseInt(urlParams.get('hotel_id')) || 0;
    const checkIn = urlParams.get('check_in');
    const checkOut = urlParams.get('check_out');

    const h = hotelsDb.find(item => item.id === hotelId) || hotelsDb[0];

    // Build Page Content
    document.getElementById('breadcrumb-title').textContent = h.title;
    document.getElementById('hotel-detail-location').innerHTML = `<i class="fa-solid fa-location-dot mr-1"></i> ${h.location}`;
    document.getElementById('hotel-detail-rating').innerHTML = `<i class="fa-solid fa-star mr-1"></i> ${h.rating} Star Rating`;
    document.getElementById('hotel-detail-title').textContent = h.title;
    
    // Build Gallery Slides dynamically
    const slidesContainer = document.getElementById('slides-container');
    const dotsContainer = document.getElementById('slider-dots-container');
    slidesContainer.innerHTML = '';
    dotsContainer.innerHTML = '';

    h.gallery.forEach((imgUrl, idx) => {
        // Create slide element
        const slideDiv = document.createElement('div');
        slideDiv.className = `gallery-slide ${idx === 0 ? 'active' : ''}`;
        slideDiv.innerHTML = `<img src="${imgUrl}" alt="Resort View Slide ${idx + 1}" class="object-cover w-full h-full">`;
        slidesContainer.appendChild(slideDiv);

        // Create dot navigation element
        const dotSpan = document.createElement('span');
        dotSpan.className = `slider-dot ${idx === 0 ? 'active' : ''}`;
        dotsContainer.appendChild(dotSpan);
    });

    // Slider Controls Logic
    let currentSlide = 0;
    const slides = document.querySelectorAll('.gallery-slide');
    const dots = document.querySelectorAll('.slider-dot');

    function showSlide(index) {
        if (slides.length === 0) return;
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        
        currentSlide = (index + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    // Bind event listeners to prev/next buttons
    document.getElementById('prev-slide-btn').addEventListener('click', () => {
        showSlide(currentSlide - 1);
    });
    document.getElementById('next-slide-btn').addEventListener('click', () => {
        showSlide(currentSlide + 1);
    });

    // Bind click events on dot indicators
    dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
            showSlide(idx);
        });
    });

    // Start auto slider loop
    let autoRotateInterval = setInterval(() => {
        showSlide(currentSlide + 1);
    }, 4500);

    // Pause auto-sliding on slide hover
    const sliderContainerEl = document.getElementById('hotel-gallery-slider');
    if (sliderContainerEl) {
        sliderContainerEl.addEventListener('mouseenter', () => {
            clearInterval(autoRotateInterval);
        });
        sliderContainerEl.addEventListener('mouseleave', () => {
            autoRotateInterval = setInterval(() => {
                showSlide(currentSlide + 1);
            }, 4500);
        });
    }

    // Render Video Showcase dynamically
    const videoContainer = document.getElementById('video-container');
    if (videoContainer) {
        videoContainer.innerHTML = '';
        const vUrl = h.video || "https://www.youtube.com/watch?v=ScXs7L0fVk0";
        
        // Check if the URL is a YouTube video
        const ytMatch = vUrl.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/);
        if (ytMatch) {
            const youtubeId = ytMatch[1];
            videoContainer.innerHTML = `<iframe src="https://www.youtube.com/embed/${youtubeId}?rel=0" allowfullscreen class="absolute inset-0 w-full h-full border-none rounded-3xl"></iframe>`;
        } else {
            // Render standard HTML5 video tag for MP4 direct links
            videoContainer.innerHTML = `<video controls src="${vUrl}" class="absolute inset-0 w-full h-full object-cover rounded-3xl"></video>`;
        }
    }

    document.getElementById('hotel-detail-description').textContent = h.description;
    document.getElementById('sidebar-price').textContent = currencySymbol + h.price;
    document.getElementById('sidebar-rating').textContent = h.rating;

    // Attach data attributes to the trigger button
    const bookingBtn = document.getElementById('details-booking-btn');
    bookingBtn.setAttribute('data-hotel', h.title);
    bookingBtn.setAttribute('data-phone', h.phone);
    bookingBtn.setAttribute('data-price', h.price);

    // Setup interactive date pass greeting inside popup modal
    const modal = document.getElementById('booking-modal');
    const modalTitle = document.getElementById('modal-hotel-title');
    const modalWelcomeText = document.getElementById('modal-welcome-text');
    const callButton = document.getElementById('modal-call-btn');
    const phoneDisplay = document.getElementById('modal-phone-number-display');
    const closeModalButtons = document.querySelectorAll('.close-modal-trigger');

    let dateRangeText = '';
    if (checkIn && checkOut) {
        const formatBriefDate = (dateStr) => {
            const date = new Date(dateStr);
            if (isNaN(date.getTime())) return dateStr;
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        };
        dateRangeText = ` for your selected dates of <strong>${formatBriefDate(checkIn)}</strong> to <strong>${formatBriefDate(checkOut)}</strong>`;
    }

    bookingBtn.addEventListener('click', function(e) {
        e.preventDefault();

        const phoneFormatted = h.phone.replace(/[^+\d]/g, '');

        modalTitle.textContent = h.title;
        
        const welcomeTemplate = (typeof travelVentureData !== 'undefined' && travelVentureData.booking_welcome_text) 
            ? travelVentureData.booking_welcome_text 
            : 'Welcome to the booking gate for [hotel_name]. We are thrilled to assist you with organizing your luxury stay[date_range].';
            
        const subTemplate = (typeof travelVentureData !== 'undefined' && travelVentureData.booking_sub_text)
            ? travelVentureData.booking_sub_text
            : 'Your reservation will be customized at the exclusive rate starting from [price] per night.';
            
        const footerTemplate = (typeof travelVentureData !== 'undefined' && travelVentureData.booking_footer_text)
            ? travelVentureData.booking_footer_text
            : 'To finalize your dates, room selection, and secure your booking, click the call button below to connect with our dedicated reservations desk.';

        // Replace placeholders
        let welcomeMessage = welcomeTemplate
            .replace('[hotel_name]', `<strong>${h.title}</strong>`)
            .replace('[date_range]', dateRangeText);
            
        const priceFormatted = `<span class="text-teal-600 font-bold">${currencySymbol}${h.price}</span>`;
        let subMessage = subTemplate.replace('[price]', priceFormatted);
        
        modalWelcomeText.innerHTML = welcomeMessage + '<br><br>' + subMessage + '<br><br>' + footerTemplate;
        phoneDisplay.textContent = h.phone;
        callButton.setAttribute('href', `tel:${phoneFormatted}`);

        // Open modal
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    closeModalButtons.forEach(trigger => {
        trigger.addEventListener('click', function() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

function initFlatpickr() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    if (!checkInInput || !checkOutInput) return;
    
    if (typeof flatpickr !== 'undefined') {
        const today = new Date();
        const tomorrow = new Date();
        tomorrow.setDate(today.getDate() + 1);

        const checkInPicker = flatpickr("#check_in", {
            minDate: "today",
            defaultDate: checkInInput.value ? undefined : today,
            dateFormat: "d M Y",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates[0]) {
                    const minOut = new Date(selectedDates[0]);
                    minOut.setDate(minOut.getDate() + 1);
                    checkOutPicker.set("minDate", minOut);
                }
            }
        });
        
        const checkOutPicker = flatpickr("#check_out", {
            minDate: tomorrow,
            defaultDate: checkOutInput.value ? undefined : tomorrow,
            dateFormat: "d M Y"
        });
    }
}

function initRoomsGuestsSelector() {
    const trigger = document.getElementById('rooms-guests-trigger');
    const popup = document.getElementById('rooms-guests-popup');
    const doneBtn = document.getElementById('done-guests-btn');
    const addRoomBtn = document.getElementById('add-room-btn');
    const container = document.getElementById('rooms-list-container');
    const display = document.getElementById('rooms-guests-display');
    const subdisplay = document.getElementById('rooms-guests-subdisplay');
    const hiddenInput = document.getElementById('hidden-guests-count');
    const warning = document.getElementById('room-guests-warning');
    
    if (!trigger || !popup || !container) return;
    
    let rooms = [
        { id: 1, adults: 2, children: 0 }
    ];
    
    // Toggle popup open/close
    trigger.addEventListener('click', function(e) {
        if (e.target.closest('#rooms-guests-popup')) return;
        popup.classList.toggle('hidden');
    });
    
    // Close popup on Done click
    if (doneBtn) {
        doneBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            popup.classList.add('hidden');
        });
    }
    
    // Close popup when clicking outside
    document.addEventListener('click', function(e) {
        if (!trigger.contains(e.target)) {
            popup.classList.add('hidden');
        }
    });
    
    // Render room elements
    function renderRooms() {
        container.innerHTML = '';
        let showWarning = false;
        
        rooms.forEach((room, index) => {
            const totalInRoom = room.adults + room.children;
            if (totalInRoom > 3) {
                showWarning = true;
            }
            
            const roomDiv = document.createElement('div');
            roomDiv.className = 'border border-slate-100 rounded-xl p-3 bg-slate-50 relative space-y-2.5';
            roomDiv.innerHTML = `
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-bold text-slate-700">Room ${index + 1}</span>
                    ${rooms.length > 1 ? `
                        <button type="button" class="remove-room-btn text-[10px] text-red-500 hover:text-red-700 font-bold border-none bg-transparent cursor-pointer" data-room-id="${room.id}">
                            Remove
                        </button>
                    ` : ''}
                </div>
                
                <!-- Adults Row -->
                <div class="flex justify-between items-center text-xs">
                    <div class="flex flex-col">
                        <span class="font-bold text-slate-800">Adults</span>
                        <span class="text-[10px] text-slate-400 font-medium">12 years +</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" class="dec-adults-btn w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center font-bold text-slate-600 hover:bg-slate-200 cursor-pointer bg-white" data-room-id="${room.id}">-</button>
                        <span class="font-bold w-4 text-center text-slate-800">${room.adults}</span>
                        <button type="button" class="inc-adults-btn w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center font-bold text-slate-600 hover:bg-slate-200 cursor-pointer bg-white" data-room-id="${room.id}">+</button>
                    </div>
                </div>
                
                <!-- Children Row -->
                <div class="flex justify-between items-center text-xs">
                    <div class="flex flex-col">
                        <span class="font-bold text-slate-800">Child</span>
                        <span class="text-[10px] text-slate-400 font-medium">0-12 years</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" class="dec-children-btn w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center font-bold text-slate-600 hover:bg-slate-200 cursor-pointer bg-white" data-room-id="${room.id}">-</button>
                        <span class="font-bold w-4 text-center text-slate-800">${room.children}</span>
                        <button type="button" class="inc-children-btn w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center font-bold text-slate-600 hover:bg-slate-200 cursor-pointer bg-white" data-room-id="${room.id}">+</button>
                    </div>
                </div>
            `;
            container.appendChild(roomDiv);
        });
        
        // Show/hide warning block
        if (showWarning) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
        
        updateDisplaySummary();
    }
    
    // Add Room button click listener
    if (addRoomBtn) {
        addRoomBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const newId = rooms.length ? Math.max(...rooms.map(r => r.id)) + 1 : 1;
            rooms.push({ id: newId, adults: 2, children: 0 });
            renderRooms();
        });
    }
    
    // Event delegation inside container for increment/decrement/remove
    container.addEventListener('click', function(e) {
        e.stopPropagation();
        
        const target = e.target;
        const roomId = parseInt(target.getAttribute('data-room-id'));
        if (isNaN(roomId)) return;
        
        const room = rooms.find(r => r.id === roomId);
        if (!room) return;
        
        if (target.classList.contains('dec-adults-btn')) {
            if (room.adults > 1) {
                room.adults--;
                renderRooms();
            }
        } else if (target.classList.contains('inc-adults-btn')) {
            if (room.adults < 10) {
                room.adults++;
                renderRooms();
            }
        } else if (target.classList.contains('dec-children-btn')) {
            if (room.children > 0) {
                room.children--;
                renderRooms();
            }
        } else if (target.classList.contains('inc-children-btn')) {
            if (room.children < 10) {
                room.children++;
                renderRooms();
            }
        } else if (target.classList.contains('remove-room-btn')) {
            rooms = rooms.filter(r => r.id !== roomId);
            renderRooms();
        }
    });
    
    // Update summary text
    function updateDisplaySummary() {
        const totalRooms = rooms.length;
        let totalAdults = 0;
        let totalChildren = 0;
        
        rooms.forEach(r => {
            totalAdults += r.adults;
            totalChildren += r.children;
        });
        
        const totalGuests = totalAdults + totalChildren;
        
        // Update labels
        display.textContent = `${totalRooms} Room${totalRooms > 1 ? 's' : ''}, ${totalGuests} Guest${totalGuests > 1 ? 's' : ''}`;
        
        let sublabelText = `${totalAdults} Adult${totalAdults > 1 ? 's' : ''}`;
        if (totalChildren > 0) {
            sublabelText += `, ${totalChildren} Child${totalChildren > 1 ? 'ren' : ''}`;
        }
        subdisplay.textContent = sublabelText;
        
        // Update hidden inputs
        if (hiddenInput) {
            hiddenInput.value = totalGuests;
        }
    }
    
    // Init rendering
    renderRooms();
}

// Auto-run controllers based on route markers
document.addEventListener('DOMContentLoaded', function() {
    initExplorer();
    initDetails();
    initFlatpickr();
    initRoomsGuestsSelector();
});
