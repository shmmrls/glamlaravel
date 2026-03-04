// Search Overlay and Mobile Navigation Functionality
document.addEventListener('DOMContentLoaded', function() {
  const searchTriggerBtns = document.querySelectorAll('.search-trigger-btn');
  const searchOverlay = document.getElementById('searchOverlay');
  const searchCloseBtn = document.querySelector('.search-close-btn');
  const searchInput = document.querySelector('.search-input');

  // Mobile Navigation elements
  const hamburgerBtn = document.querySelector('.hamburger-btn');
  const mobileNav = document.getElementById('mobile-nav');

  function openSearchOverlay() {
    if (!searchOverlay) return;
    searchOverlay.classList.add('active');
    if (searchInput) searchInput.focus();
    document.body.style.overflow = 'hidden';
  }

  function closeSearchOverlay() {
    if (!searchOverlay) return;
    searchOverlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  // Mobile Navigation functions
  function toggleMobileNav() {
    if (!mobileNav || !hamburgerBtn) return;
    
    mobileNav.classList.toggle('open');
    hamburgerBtn.classList.toggle('active');
    
    // Prevent body scroll when mobile nav is open
    if (mobileNav.classList.contains('open')) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  }

  function closeMobileNav() {
    if (!mobileNav || !hamburgerBtn) return;
    
    mobileNav.classList.remove('open');
    hamburgerBtn.classList.remove('active');
    document.body.style.overflow = '';
  }

  // Event listeners
  if (searchTriggerBtns && searchTriggerBtns.length) {
    searchTriggerBtns.forEach(btn => btn.addEventListener('click', openSearchOverlay));
  }

  if (searchCloseBtn) {
    searchCloseBtn.addEventListener('click', closeSearchOverlay);
  }

  // Mobile navigation event listeners
  if (hamburgerBtn) {
    hamburgerBtn.addEventListener('click', toggleMobileNav);
  }

  // Close mobile nav when clicking on links (for better UX)
  if (mobileNav) {
    const navLinks = mobileNav.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', function() {
        closeMobileNav();
      });
    });
  }

  // Close on escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      if (searchOverlay && searchOverlay.classList.contains('active')) {
        closeSearchOverlay();
      }
      if (mobileNav && mobileNav.classList.contains('open')) {
        closeMobileNav();
      }
    }
  });

  // Close on overlay background click
  if (searchOverlay) {
    searchOverlay.addEventListener('click', function(e) {
      if (e.target === searchOverlay) {
        closeSearchOverlay();
      }
    });
  }

  // Close mobile nav on window resize (when switching to desktop)
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      if (window.innerWidth > 749 && mobileNav && mobileNav.classList.contains('open')) {
        closeMobileNav();
      }
    }, 250);
  });
});
