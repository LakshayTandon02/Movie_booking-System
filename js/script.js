// DOM Elements
const moviesContainer = document.getElementById('moviesContainer');
const theatersContainer = document.getElementById('theatersContainer');
const upcomingContainer = document.getElementById('upcomingContainer');
const locationBtn = document.getElementById('locationBtn');
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const bookingModal = document.getElementById('bookingModal');
const closeModal = document.getElementById('closeModal');
const bookingForm = document.getElementById('bookingForm');

// Current location
let userLocation = {
    lat: null,
    lng: null,
    city: "Detecting...",
    permission: false
};

// Initialize the application
function init() {
    loadMovies();
    getLocation();
    
    // Event listeners
    searchBtn.addEventListener('click', handleSearch);
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') handleSearch();
    });
    
    locationBtn.addEventListener('click', getLocation);
    closeModal.addEventListener('click', () => bookingModal.style.display = 'none');
    
    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === bookingModal) bookingModal.style.display = 'none';
    });
    
    // Booking form submission
    bookingForm.addEventListener('submit', handleBooking);
}

// Load movies
async function loadMovies() {
    try {
        // Sample movie data
        const movies = [
            {
                id: 1,
                title: "Avengers: Endgame",
                poster_path: "/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg",
                vote_average: 8.4,
                genre_ids: [28, 12, 878]
            },
            {
                id: 2,
                title: "The Batman",
                poster_path: "/74xTEgt7R36Fpooo50r9T25onhq.jpg",
                vote_average: 7.8,
                genre_ids: [28, 80, 9648]
            }
        ];
        
        displayMovies(movies, moviesContainer);
    } catch (error) {
        console.error('Error loading movies:', error);
    }
}

// Display movies
function displayMovies(movies, container) {
    container.innerHTML = '';
    
    movies.forEach(movie => {
        const movieCard = document.createElement('div');
        movieCard.classList.add('movie-card');
        
        const posterPath = movie.poster_path 
            ? `https://image.tmdb.org/t/p/w500${movie.poster_path}`
            : 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
        
        movieCard.innerHTML = `
            <img src="${posterPath}" alt="${movie.title}" class="movie-poster">
            <div class="movie-details">
                <h3 class="movie-title">${movie.title}</h3>
                <div class="movie-info">
                    <span>Action</span>
                    <span class="rating">★ ${movie.vote_average}</span>
                </div>
                <button class="btn-book" data-movie-id="${movie.id}" data-movie-title="${movie.title}">Book Tickets</button>
            </div>
        `;
        
        container.appendChild(movieCard);
    });
    
    // Add event listeners to book buttons
    document.querySelectorAll('.btn-book').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const movieId = button.getAttribute('data-movie-id');
            const movieTitle = button.getAttribute('data-movie-title');
            openBookingModal(movieId, movieTitle);
        });
    });
}

// Get user's location
function getLocation() {
    locationBtn.textContent = "Detecting location...";
    
    if (!navigator.geolocation) {
        locationBtn.textContent = "Geolocation not supported";
        userLocation.city = "Bangalore";
        loadTheaters();
        return;
    }
    
    navigator.geolocation.getCurrentPosition(
        (position) => {
            userLocation.lat = position.coords.latitude;
            userLocation.lng = position.coords.longitude;
            userLocation.permission = true;
            userLocation.city = "Bangalore";
            locationBtn.textContent = userLocation.city;
            loadTheaters();
        },
        (error) => {
            console.error('Error getting location:', error);
            locationBtn.textContent = "Location access denied";
            userLocation.city = "Bangalore";
            loadTheaters();
        }
    );
}

// Load theaters
async function loadTheaters() {
    try {
        const data = await movieAPI.getTheaters(userLocation.lat, userLocation.lng);
        displayTheaters(data.theaters);
    } catch (error) {
        console.error('Error loading theaters:', error);
    }
}

// Display theaters
function displayTheaters(theaters) {
    theatersContainer.innerHTML = '';
    
    theaters.forEach(theater => {
        const theaterCard = document.createElement('div');
        theaterCard.classList.add('theater-card');
        
        theaterCard.innerHTML = `
            <div class="theater-info">
                <h3 class="theater-name">${theater.name}</h3>
                <p class="theater-address">${theater.address} • ${theater.distance}</p>
                <p class="theater-price">From ₹${theater.price}</p>
            </div>
            <div class="show-timings">
                <button class="time-btn">10:00 AM</button>
                <button class="time-btn">1:30 PM</button>
                <button class="time-btn">4:45 PM</button>
                <button class="time-btn">8:00 PM</button>
            </div>
        `;
        
        theatersContainer.appendChild(theaterCard);
    });
}

// Open booking modal
function openBookingModal(movieId, movieTitle) {
    // Populate movie select
    const movieSelect = document.getElementById('movieSelect');
    movieSelect.innerHTML = '<option value="">Select a movie</option>';
    const option = document.createElement('option');
    option.value = movieId;
    option.textContent = movieTitle;
    option.selected = true;
    movieSelect.appendChild(option);
    
    // Show modal
    bookingModal.style.display = 'flex';
}

// Handle booking form submission
async function handleBooking(e) {
    e.preventDefault();
    
    const formData = {
        movie_id: document.getElementById('movieSelect').value,
        theater_id: 1, // Sample theater ID
        showtime: '2023-12-25 18:30:00', // Sample showtime
        seats: document.getElementById('seats').value,
        user_name: document.getElementById('name').value,
        user_email: document.getElementById('email').value,
        user_phone: document.getElementById('phone').value
    };
    
    try {
        const result = await movieAPI.createBooking(formData);
        alert(`Booking confirmed!\nBooking Reference: ${result.booking_ref}`);
        bookingModal.style.display = 'none';
        bookingForm.reset();
    } catch (error) {
        alert('Error creating booking. Please try again.');
    }
}

// Handle search
function handleSearch() {
    const query = searchInput.value.trim();
    if (query) {
        alert(`Search functionality for: "${query}" would be implemented here!`);
    }
}

// Initialize the app when the DOM is loaded
document.addEventListener('DOMContentLoaded', init);
// Authentication variables
let currentUserId = null;
let currentVerificationMethod = 'email';

// Initialize authentication
function initAuth() {
    // Check if user is already logged in
    const session = movieAPI.getSession();
    if (session) {
        updateUIForLoggedInUser(session.user);
    }

    // Event listeners for auth modals
    document.getElementById('loginBtn').addEventListener('click', () => showModal('loginModal'));
    document.getElementById('registerBtn').addEventListener('click', () => showModal('registerModal'));
    
    document.getElementById('showRegister').addEventListener('click', (e) => {
        e.preventDefault();
        hideModal('loginModal');
        showModal('registerModal');
    });
    
    document.getElementById('showLogin').addEventListener('click', (e) => {
        e.preventDefault();
        hideModal('registerModal');
        showModal('loginModal');
    });

    // Form submissions
    document.getElementById('loginForm').addEventListener('submit', handleLogin);
    document.getElementById('registerForm').addEventListener('submit', handleRegister);
    document.getElementById('otpForm').addEventListener('submit', handleOTPVerification);
    
    document.getElementById('resendOtp').addEventListener('click', (e) => {
        e.preventDefault();
        resendOTP();
    });

    // Close buttons for all modals
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            hideModal(modalId);
        });
    });
}

// Show modal function
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
}

// Hide modal function
function hideModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Handle registration
async function handleRegister(e) {
    e.preventDefault();
    
    const name = document.getElementById('registerName').value;
    const email = document.getElementById('registerEmail').value;
    const phone = document.getElementById('registerPhone').value;
    const password = document.getElementById('registerPassword').value;
    const via = document.querySelector('input[name="verifyVia"]:checked').value;

    try {
        const result = await movieAPI.register({ name, email, phone, password, via });
        
        if (result.success) {
            currentUserId = result.user_id;
            currentVerificationMethod = via;
            
            // Update OTP message
            const otpMessage = document.getElementById('otpMessage');
            otpMessage.textContent = `Please enter the OTP sent to your ${via === 'email' ? email : phone}`;
            
            // Show OTP modal
            hideModal('registerModal');
            showModal('otpModal');
        } else {
            alert('Registration failed: ' + result.message);
        }
    } catch (error) {
        alert('Registration error. Please try again.');
    }
}

// Handle OTP verification
async function handleOTPVerification(e) {
    e.preventDefault();
    
    const otp = document.getElementById('otpCode').value;

    try {
        const result = await movieAPI.verifyOTP(currentUserId, otp, currentVerificationMethod);
        
        if (result.success) {
            alert('Account verified successfully! You can now login.');
            hideModal('otpModal');
            showModal('loginModal');
        } else {
            alert('Verification failed: ' + result.message);
        }
    } catch (error) {
        alert('Verification error. Please try again.');
    }
}

// Handle login
async function handleLogin(e) {
    e.preventDefault();
    
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    try {
        const result = await movieAPI.login({ email, password });
        
        if (result.success) {
            // Store session
            movieAPI.setSession({
                token: result.session_token,
                user: result.user
            });
            
            // Update UI
            updateUIForLoggedInUser(result.user);
            
            // Hide modal
            hideModal('loginModal');
            
            alert('Login successful! Welcome back, ' + result.user.name);
        } else {
            alert('Login failed: ' + result.message);
        }
    } catch (error) {
        alert('Login error. Please try again.');
    }
}

// Resend OTP
async function resendOTP() {
    try {
        const result = await movieAPI.resendOTP(currentUserId, currentVerificationMethod);
        
        if (result.success) {
            alert('New OTP sent successfully!');
        } else {
            alert('Failed to resend OTP: ' + result.message);
        }
    } catch (error) {
        alert('Error resending OTP. Please try again.');
    }
}

// Update UI for logged in user
function updateUIForLoggedInUser(user) {
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');
    
    // Replace login/register buttons with user menu
    loginBtn.textContent = user.name;
    loginBtn.onclick = showUserMenu;
    registerBtn.style.display = 'none';
    
    // You can add a user dropdown menu here
}

// Show user menu (simplified)
function showUserMenu() {
    // Implement user dropdown menu
    alert('User menu would show here with options like Profile, Bookings, Logout');
}

// Add this to your init function
document.addEventListener('DOMContentLoaded', function() {
    init();
    initAuth(); // Initialize authentication
});