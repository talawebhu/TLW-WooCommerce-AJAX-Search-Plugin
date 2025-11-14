(function($) {
    'use strict';

    class TLWWooAjaxSearch {
        constructor() {
            this.searchTimeout = null;
            this.currentRequest = null;
            this.init();
        }

        init() {
            this.bindEvents();
        }

        bindEvents() {
            const self = this;
            
            // Handle input in search field
            $(document).on('input', '.tlw-woo-search-input', function() {
                const $input = $(this);
                const $container = $input.closest('.tlw-woo-search-container');
                const query = $input.val().trim();

                // Clear previous timeout
                if (self.searchTimeout) {
                    clearTimeout(self.searchTimeout);
                }

                // Clear results if query is empty
                if (query.length === 0) {
                    self.clearResults($container);
                    return;
                }

                // Check minimum characters
                if (query.length < 2) {
                    self.showMessage($container, tlwWooAjaxSearch.strings.minChars, 'info');
                    return;
                }

                // Delay search to avoid too many requests
                self.searchTimeout = setTimeout(function() {
                    self.performSearch($container, query);
                }, 300);
            });

            // Close results when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.tlw-woo-search-container').length) {
                    $('.tlw-woo-search-results').hide();
                }
            });

            // Show results when clicking on input
            $(document).on('click', '.tlw-woo-search-input', function() {
                const $results = $(this).siblings('.tlw-woo-search-results');
                if ($results.children().length > 0) {
                    $results.show();
                }
            });

            // Handle keyboard navigation
            $(document).on('keydown', '.tlw-woo-search-input', function(e) {
                const $results = $(this).siblings('.tlw-woo-search-results');
                const $items = $results.find('.tlw-search-result-item');
                const $active = $items.filter('.active');

                if (e.keyCode === 40) { // Arrow Down
                    e.preventDefault();
                    if ($active.length === 0) {
                        $items.first().addClass('active');
                    } else {
                        $active.removeClass('active').next().addClass('active');
                    }
                } else if (e.keyCode === 38) { // Arrow Up
                    e.preventDefault();
                    if ($active.length > 0) {
                        $active.removeClass('active').prev().addClass('active');
                    }
                } else if (e.keyCode === 13) { // Enter
                    e.preventDefault();
                    if ($active.length > 0) {
                        // Navigate to selected product
                        window.location.href = $active.find('a').attr('href');
                    } else {
                        // Submit the form to show all search results
                        $(this).closest('form').submit();
                    }
                } else if (e.keyCode === 27) { // Escape
                    $results.hide();
                }
            });
        }

        performSearch($container, query) {
            const self = this;
            const $results = $container.find('.tlw-woo-search-results');
            
            // Cancel previous request if exists
            if (this.currentRequest) {
                this.currentRequest.abort();
            }

            // Show loading state
            this.showLoading($container);

            // Perform AJAX request
            this.currentRequest = $.ajax({
                url: tlwWooAjaxSearch.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'tlw_woo_search',
                    nonce: tlwWooAjaxSearch.nonce,
                    query: query
                },
                success: function(response) {
                    if (response.success && response.data.products) {
                        if (response.data.products.length > 0) {
                            self.displayResults($container, response.data.products);
                        } else {
                            self.showMessage($container, response.data.message || tlwWooAjaxSearch.strings.noResults, 'no-results');
                        }
                    } else {
                        self.showMessage($container, response.data.message || tlwWooAjaxSearch.strings.error, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.statusText !== 'abort') {
                        self.showMessage($container, tlwWooAjaxSearch.strings.error, 'error');
                    }
                },
                complete: function() {
                    self.currentRequest = null;
                    $container.removeClass('loading');
                }
            });
        }

        displayResults($container, products) {
            const $results = $container.find('.tlw-woo-search-results');
            const $input = $container.find('.tlw-woo-search-input');
            const query = $input.val().trim();
            let html = '<div class="tlw-search-results-list">';

            products.forEach(function(product) {
                const stockClass = product.in_stock ? 'in-stock' : 'out-of-stock';
                
                html += `
                    <div class="tlw-search-result-item ${stockClass}">
                        <a href="${product.url}" class="tlw-search-result-link">
                            <div class="tlw-search-result-image">
                                <img src="${product.image}" alt="${product.title}">
                            </div>
                            <div class="tlw-search-result-content">
                                <h4 class="tlw-search-result-title">${product.title}</h4>
                                ${product.excerpt ? `<p class="tlw-search-result-excerpt">${product.excerpt}</p>` : ''}
                                <div class="tlw-search-result-meta">
                                    <span class="tlw-search-result-price">${product.price}</span>
                                    <span class="tlw-search-result-stock ${stockClass}">${product.stock_status}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
            });

            html += '</div>';
            
            // Add "View All Results" link
            const searchUrl = $container.find('form').attr('action') + '?s=' + encodeURIComponent(query) + '&post_type=product';
            html += `
                <div class="tlw-search-view-all">
                    <a href="${searchUrl}" class="tlw-search-view-all-link">
                        ${tlwWooAjaxSearch.strings.viewAll}
                    </a>
                </div>
            `;
            
            $results.html(html).show();
        }

        showMessage($container, message, type) {
            const $results = $container.find('.tlw-woo-search-results');
            const html = `<div class="tlw-search-message tlw-search-message-${type}">${message}</div>`;
            $results.html(html).show();
        }

        showLoading($container) {
            $container.addClass('loading');
            const $results = $container.find('.tlw-woo-search-results');
            const html = `<div class="tlw-search-loading">${tlwWooAjaxSearch.strings.searching}</div>`;
            $results.html(html).show();
        }

        clearResults($container) {
            $container.find('.tlw-woo-search-results').empty().hide();
            $container.removeClass('loading');
        }
    }

    // Initialize when document is ready
    $(document).ready(function() {
        new TLWWooAjaxSearch();
    });

})(jQuery);
