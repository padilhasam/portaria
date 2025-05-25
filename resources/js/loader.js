document.addEventListener("DOMContentLoaded", function() {
    const loader = document.getElementById('page-loader');

    document.querySelectorAll('a[href]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            if (
                !href ||
                href.startsWith('#') ||
                this.target === '_blank' ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:') ||
                (href.startsWith('http') && !href.includes(location.hostname))
            ) {
                return; // Ignora links externos, mailto, tel, etc.
            }

            loader.style.display = 'flex';
        });
    });

    window.addEventListener('pageshow', function() {
        loader.style.display = 'none';
    });
});