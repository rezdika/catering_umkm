document.addEventListener('DOMContentLoaded', function() {
    const heroSearch = document.getElementById('heroSearch');
    const sidebarSearch = document.getElementById('sidebarSearch');
    const categoryFilters = document.querySelectorAll('.category-filter');
    const tagFilters = document.querySelectorAll('.tag-filter');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const applyPriceFilter = document.getElementById('applyPriceFilter');
    const sortSelect = document.getElementById('sortSelect');
    const menuItems = document.querySelectorAll('.menu-item');
    const resultsCount = document.getElementById('resultsCount');
    const menuGrid = document.getElementById('menuGrid');
    
    let currentFilters = {
        search: '',
        category: 'all',
        tags: [],
        minPrice: null,
        maxPrice: null,
        sort: 'default'
    };
    
    // Search functionality
    function handleSearch(searchTerm) {
        currentFilters.search = searchTerm.toLowerCase();
        filterAndSort();
    }
    
    heroSearch.addEventListener('input', (e) => {
        sidebarSearch.value = e.target.value;
        handleSearch(e.target.value);
    });
    
    sidebarSearch.addEventListener('input', (e) => {
        heroSearch.value = e.target.value;
        handleSearch(e.target.value);
    });
    
    // Category filter
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', (e) => {
            e.preventDefault();
            categoryFilters.forEach(f => f.classList.remove('bg-brand-red', 'text-white'));
            filter.classList.add('bg-brand-red', 'text-white');
            currentFilters.category = filter.dataset.category;
            filterAndSort();
        });
    });
    
    // Tag filters
    tagFilters.forEach(tag => {
        tag.addEventListener('click', () => {
            const tagValue = tag.dataset.tag;
            if (currentFilters.tags.includes(tagValue)) {
                currentFilters.tags = currentFilters.tags.filter(t => t !== tagValue);
                tag.classList.remove('bg-brand-red', 'text-white');
                tag.classList.add('bg-gray-100', 'text-brand-black');
            } else {
                currentFilters.tags.push(tagValue);
                tag.classList.remove('bg-gray-100', 'text-brand-black');
                tag.classList.add('bg-brand-red', 'text-white');
            }
            filterAndSort();
        });
    });
    
    // Price filter
    applyPriceFilter.addEventListener('click', () => {
        currentFilters.minPrice = minPriceInput.value ? parseInt(minPriceInput.value) : null;
        currentFilters.maxPrice = maxPriceInput.value ? parseInt(maxPriceInput.value) : null;
        filterAndSort();
    });
    
    // Sort functionality
    sortSelect.addEventListener('change', (e) => {
        currentFilters.sort = e.target.value;
        console.log('Sort changed to:', currentFilters.sort);
        filterAndSort();
    });
    
    // Grid/List view toggle
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    
    gridView.addEventListener('click', () => {
        gridView.classList.add('bg-brand-red', 'text-white');
        gridView.classList.remove('text-brand-black');
        listView.classList.remove('bg-brand-red', 'text-white');
        listView.classList.add('text-brand-black');
        
        // Switch to grid view
        menuGrid.className = 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6';
    });
    
    listView.addEventListener('click', () => {
        listView.classList.add('bg-brand-red', 'text-white');
        listView.classList.remove('text-brand-black');
        gridView.classList.remove('bg-brand-red', 'text-white');
        gridView.classList.add('text-brand-black');
        
        // Switch to list view
        menuGrid.className = 'grid grid-cols-1 gap-4';
    });
    
    // Filter and sort function
    function filterAndSort() {
        let filteredItems = Array.from(menuItems).filter(item => {
            const itemName = item.querySelector('h3').textContent.toLowerCase();
            const itemDescription = item.querySelector('p').textContent.toLowerCase();
            const itemCategory = item.dataset.category;
            const itemPrice = parseInt(item.dataset.price);
            const itemTags = item.dataset.tags ? item.dataset.tags.split(',') : [];
            
            // Search filter
            if (currentFilters.search && 
                !itemName.includes(currentFilters.search) && 
                !itemDescription.includes(currentFilters.search)) {
                return false;
            }
            
            // Category filter
            if (currentFilters.category !== 'all' && itemCategory !== currentFilters.category) {
                return false;
            }
            
            // Tag filter
            if (currentFilters.tags.length > 0) {
                const hasMatchingTag = currentFilters.tags.some(tag => itemTags.includes(tag));
                if (!hasMatchingTag) return false;
            }
            
            // Price filter
            if (currentFilters.minPrice && itemPrice < currentFilters.minPrice) {
                return false;
            }
            if (currentFilters.maxPrice && itemPrice > currentFilters.maxPrice) {
                return false;
            }
            
            return true;
        });
        
        // Sort items
        if (currentFilters.sort !== 'default') {
            console.log('Sorting items by:', currentFilters.sort);
            console.log('Items before sort:', filteredItems.map(item => ({
                name: item.querySelector('h3').textContent,
                price: parseInt(item.dataset.price)
            })));
            
            filteredItems.sort((a, b) => {
                const priceA = parseInt(a.dataset.price);
                const priceB = parseInt(b.dataset.price);
                const nameA = a.querySelector('h3').textContent.toLowerCase();
                const nameB = b.querySelector('h3').textContent.toLowerCase();
                const tagsA = a.dataset.tags ? a.dataset.tags.split(',') : [];
                const tagsB = b.dataset.tags ? b.dataset.tags.split(',') : [];
                
                switch (currentFilters.sort) {
                    case 'price-low':
                        return priceA - priceB;
                    case 'price-high':
                        return priceB - priceA;
                    case 'popular':
                        // Sort by bestseller and favorit tags first, then by price
                        const popularA = tagsA.includes('bestseller') || tagsA.includes('favorit') ? 1 : 0;
                        const popularB = tagsB.includes('bestseller') || tagsB.includes('favorit') ? 1 : 0;
                        if (popularB !== popularA) return popularB - popularA;
                        return priceA - priceB;
                    case 'newest':
                        // Sort by baru tag first, then by name
                        const newA = tagsA.includes('baru') ? 1 : 0;
                        const newB = tagsB.includes('baru') ? 1 : 0;
                        if (newB !== newA) return newB - newA;
                        return nameA.localeCompare(nameB);
                    default:
                        return 0;
                }
            });
            
            console.log('Items after sort:', filteredItems.map(item => ({
                name: item.querySelector('h3').textContent,
                price: parseInt(item.dataset.price)
            })));
        }
        
        // Clear current grid
        menuGrid.innerHTML = '';
        
        // Add filtered items to grid in sorted order
        filteredItems.forEach(item => {
            menuGrid.appendChild(item);
        });
        
        // Update results count
        const totalItems = menuItems.length;
        const visibleItems = filteredItems.length;
        resultsCount.textContent = `Menampilkan 1-${visibleItems} dari ${visibleItems} hasil`;
        
        // Show no results message if needed
        if (filteredItems.length === 0) {
            if (!document.getElementById('noResults')) {
                const noResults = document.createElement('div');
                noResults.id = 'noResults';
                noResults.className = 'col-span-full text-center py-12';
                noResults.innerHTML = `
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada menu yang ditemukan</h3>
                    <p class="text-gray-500">Coba ubah filter atau kata kunci pencarian Anda</p>
                `;
                menuGrid.appendChild(noResults);
            }
        } else {
            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.remove();
            }
        }
    }
    
    // Hero search button
    document.querySelector('#heroSearch + button').addEventListener('click', () => {
        handleSearch(heroSearch.value);
    });
    
    // Enter key for search
    [heroSearch, sidebarSearch].forEach(input => {
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                handleSearch(input.value);
            }
        });
    });
});