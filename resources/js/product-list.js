
// Apply filters when dropdown changes
function applyFilters() {
    const category = document.querySelector('select[name="category"]').value;
    const sort = document.querySelector('select[name="sort"]').value;
    const search = document.getElementById('searchInput').value;
    
    let url = window.location.pathname + '?';
    const params = [];
    
    if (category && category !== '0') {
        params.push('category=' + category);
    }
    if (sort && sort !== 'name_asc') {
        params.push('sort=' + sort);
    }
    if (search) {
        params.push('search=' + encodeURIComponent(search));
    }
    
    url += params.join('&');
    window.location.href = url;
}

// Clear all filters
function clearFilters() {
    // Clear search input
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Reset dropdowns to default values
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    
    if (categoryFilter) {
        categoryFilter.value = '0';
    }
    if (sortFilter) {
        sortFilter.value = 'name_asc';
    }
    
    // Redirect to clean URL
    window.location.href = window.location.pathname;
}

// Remove specific filter
function removeFilter(filterType) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.delete(filterType);
    
    let url = window.location.pathname;
    if (urlParams.toString()) {
        url += '?' + urlParams.toString();
    }
    window.location.href = url;
}

// Clear search
function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    applyFilters();
}

// Wait for DOM to be ready before attaching event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Attach change handlers to filter selects
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', applyFilters);
    }
    if (sortFilter) {
        sortFilter.addEventListener('change', applyFilters);
    }

    // Real-time search with debounce
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFilters();
            }, 500);
        });
    }

    // Prevent form submission on Enter (handled by real-time search)
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });
    }
});
