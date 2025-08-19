<x-layouts.app.layout>
    <!-- Blog Archive Page Content (place between your site's header and footer) -->
    <div x-data="blogArchive()" x-init="init()" class="max-w-[1440px] mx-auto px-4 py-12">
        <!-- Page title & intro -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight">Blogs</h1>
                <p class="mt-2 text-gray-600">Insights, news, and guides from our vapor team. Dummy posts shown below —
                    replace with your own.</p>
            </div>

            <!-- Controls -->
            <div class="flex flex-col sm:flex-row gap-3 sm:items-center">
                <div class="relative w-full sm:w-72">
                    <input type="text" x-model="q" placeholder="Search articles…"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 pr-10 shadow-sm focus:border-gray-900 focus:ring-0">
                    <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 opacity-60"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </div>

                <select x-model="activeCategory"
                    class="rounded-2xl border border-gray-300 bg-white px-3 py-3 shadow-sm focus:border-gray-900 focus:ring-0 pr-10">
                    <option value="">All categories</option>
                    <template x-for="c in categories" :key="c">
                        <option :value="c" x-text="c"></option>
                    </template>
                </select>

                <select x-model="sort"
                    class="rounded-2xl border border-gray-300 bg-white px-3 py-3 shadow-sm focus:border-gray-900 focus:ring-0 pr-10">
                    <option value="newest">Newest first</option>
                    <option value="oldest">Oldest first</option>
                </select>
            </div>
        </div>

        <!-- Posts grid -->
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <template x-for="post in pagedPosts" :key="post.id">
                <article class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
                    <a href="#" class="block aspect-[16/9] bg-gray-100">
                        <img :src="post.image" :alt="post.title" class="h-full w-full object-cover"
                            loading="lazy">
                    </a>
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="inline-flex items-center gap-1">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 0 0 2-2v-6H3v6a2 2 0 0 0 2 2Z" />
                                </svg>
                                <span x-text="formatDate(post.date)"></span>
                            </span>
                            <span>•</span>
                            <a href="#" class="underline decoration-dotted underline-offset-2"
                                x-text="post.category"></a>
                        </div>
                        <h2 class="mt-3 text-lg font-semibold leading-snug">
                            <a href="#" class="hover:underline" x-text="post.title"></a>
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-3" x-text="post.excerpt"></p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <template x-for="tag in post.tags" :key="tag">
                                <span class="text-xs bg-gray-100 text-gray-700 rounded-full px-2.5 py-1">#<span
                                        x-text="tag"></span></span>
                            </template>
                        </div>
                        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <a href="#" class="text-sm font-medium text-gray-900 hover:underline">Read more →</a>
                            <div class="text-xs text-gray-500" x-text="post.readTime + ' min read'"></div>
                        </div>
                    </div>
                </article>
            </template>
        </div>

        <!-- Empty state -->
        <div x-show="filteredPosts.length === 0" class="mt-16 text-center">
            <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center">
                <svg class="h-7 w-7 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-semibold">No posts found</h3>
            <p class="mt-2 text-gray-600">Try a different search term or category.</p>
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex items-center justify-center gap-2" x-show="totalPages > 1">
            <button @click="prevPage" :disabled="page === 1"
                class="px-3 py-2 rounded-xl border border-gray-300 bg-white text-sm disabled:opacity-40">Prev</button>
            <template x-for="p in totalPages" :key="p">
                <button @click="go(p)"
                    :class="{ 'bg-gray-900 text-white': page === p, 'bg-white text-gray-900': page !== p }"
                    class="px-3 py-2 rounded-xl border border-gray-300 text-sm">
                    <span x-text="p"></span>
                </button>
            </template>
            <button @click="nextPage" :disabled="page === totalPages"
                class="px-3 py-2 rounded-xl border border-gray-300 bg-white text-sm disabled:opacity-40">Next</button>
        </div>
    </div>

    <script>
        function blogArchive() {
            return {
                q: '',
                sort: 'newest',
                activeCategory: '',
                page: 1,
                perPage: 9,
                posts: [
                    // --- Dummy posts (replace with real data) ---
                    {
                        id: 1,
                        title: 'Beginner’s Guide to Vape Devices',
                        date: '2025-07-12',
                        category: 'Guides',
                        tags: ['getting-started', 'devices'],
                        readTime: 6,
                        image: 'https://picsum.photos/seed/vape1/800/450',
                        excerpt: 'Learn the basics of pods, mods, coils, and how to pick your first setup.'
                    },
                    {
                        id: 2,
                        title: 'How to Choose Nicotine Strength',
                        date: '2025-06-30',
                        category: 'Guides',
                        tags: ['nicotine', 'health'],
                        readTime: 5,
                        image: 'https://picsum.photos/seed/vape2/800/450',
                        excerpt: 'Understand strengths, freebase vs salts, and tips to switch from smoking.'
                    },
                    {
                        id: 3,
                        title: 'Summer Flavors: Staff Picks',
                        date: '2025-06-05',
                        category: 'Flavors',
                        tags: ['fruity', 'top-picks'],
                        readTime: 4,
                        image: 'https://picsum.photos/seed/vape3/800/450',
                        excerpt: 'Refresh your palate with bright and breezy blends perfect for warm days.'
                    },
                    {
                        id: 4,
                        title: 'Shipping Updates & Lead Times',
                        date: '2025-05-28',
                        category: 'News',
                        tags: ['shipping', 'policy'],
                        readTime: 3,
                        image: 'https://picsum.photos/seed/vape4/800/450',
                        excerpt: 'What to expect during peak seasons and how we keep you updated.'
                    },
                    {
                        id: 5,
                        title: 'Coil Care 101',
                        date: '2025-05-17',
                        category: 'Guides',
                        tags: ['maintenance', 'coils'],
                        readTime: 7,
                        image: 'https://picsum.photos/seed/vape5/800/450',
                        excerpt: 'Extend coil life with proper priming, wattage, and e‑liquid choices.'
                    },
                    {
                        id: 6,
                        title: 'Flavor Bans & Compliance',
                        date: '2025-04-29',
                        category: 'Compliance',
                        tags: ['regulations', 'compliance'],
                        readTime: 8,
                        image: 'https://picsum.photos/seed/vape6/800/450',
                        excerpt: 'An overview of current restrictions and how they may affect orders.'
                    },
                    {
                        id: 7,
                        title: 'Battery Safety Essentials',
                        date: '2025-04-09',
                        category: 'Safety',
                        tags: ['batteries', 'safety'],
                        readTime: 6,
                        image: 'https://picsum.photos/seed/vape7/800/450',
                        excerpt: 'Best practices for charging, storage, and handling 18650 cells.'
                    },
                    {
                        id: 8,
                        title: 'Top Accessories in 2025',
                        date: '2025-03-22',
                        category: 'Products',
                        tags: ['accessories', 'roundup'],
                        readTime: 5,
                        image: 'https://picsum.photos/seed/vape8/800/450',
                        excerpt: 'From cases to chargers—our most‑used add‑ons of the year so far.'
                    },
                    {
                        id: 9,
                        title: 'E‑liquid Ingredients Explained',
                        date: '2025-03-02',
                        category: 'Guides',
                        tags: ['ingredients', 'eliquid'],
                        readTime: 9,
                        image: 'https://picsum.photos/seed/vape9/800/450',
                        excerpt: 'PG, VG, flavorings, and what those labels really mean.'
                    },
                    {
                        id: 10,
                        title: 'Warehouse Move: What Changes?',
                        date: '2025-02-18',
                        category: 'News',
                        tags: ['fulfilment', 'operations'],
                        readTime: 3,
                        image: 'https://picsum.photos/seed/vape10/800/450',
                        excerpt: 'We’re upgrading our logistics—here’s how it improves your orders.'
                    },
                    {
                        id: 11,
                        title: 'Choosing a Pod System in 2025',
                        date: '2025-01-25',
                        category: 'Products',
                        tags: ['pods', 'devices'],
                        readTime: 6,
                        image: 'https://picsum.photos/seed/vape11/800/450',
                        excerpt: 'What to compare: capacity, coil options, airflow, and durability.'
                    },
                    {
                        id: 12,
                        title: 'Returns & Warranty—How It Works',
                        date: '2025-01-10',
                        category: 'Policy',
                        tags: ['returns', 'warranty'],
                        readTime: 4,
                        image: 'https://picsum.photos/seed/vape12/800/450',
                        excerpt: 'A quick guide to eligibility, timelines, and how to file a claim.'
                    }
                ],
                get categories() {
                    return [...new Set(this.posts.map(p => p.category))].sort();
                },
                get filteredPosts() {
                    let list = this.posts.filter(p => {
                        const matchesQ = !this.q || (p.title + ' ' + p.excerpt + ' ' + p.tags.join(' '))
                            .toLowerCase().includes(this.q.toLowerCase());
                        const matchesCat = !this.activeCategory || p.category === this.activeCategory;
                        return matchesQ && matchesCat;
                    });
                    list.sort((a, b) => this.sort === 'newest' ? (b.date.localeCompare(a.date)) : (a.date.localeCompare(
                        b.date)));
                    return list;
                },
                get totalPages() {
                    return Math.max(1, Math.ceil(this.filteredPosts.length / this.perPage));
                },
                get pagedPosts() {
                    const start = (this.page - 1) * this.perPage;
                    return this.filteredPosts.slice(start, start + this.perPage);
                },
                formatDate(d) {
                    try {
                        return new Date(d).toLocaleDateString(undefined, {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                    } catch {
                        return d;
                    }
                },
                go(p) {
                    this.page = p;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },
                nextPage() {
                    if (this.page < this.totalPages) this.go(this.page + 1);
                },
                prevPage() {
                    if (this.page > 1) this.go(this.page - 1);
                },
                init() {
                    /* could fetch posts via API here */ }
            }
        }
    </script>

</x-layouts.app.layout>
