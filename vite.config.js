import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/index.css',
                'resources/css/hero.css',
                'resources/css/home-search.css',
                'resources/css/category-showcase.css',
                'resources/css/featured-products-home.css',
                'resources/css/whoarewe.css',
                'resources/css/product-list.css',
                'resources/css/product.css',
                'resources/css/login.css',
                'resources/css/footer.css',
                'resources/css/profile.css',
                'resources/css/featured.css',
                'resources/css/items.css',
                'resources/css/style.css',
                'resources/css/admin-dashboard.css',
                'resources/css/analytics.css',
                'resources/js/app.js',
                'resources/js/product-list.js',
                'resources/js/product.js'
            ],
            refresh: true,
        }),
    ],
});