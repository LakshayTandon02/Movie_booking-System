// API Configuration
const API_BASE_URL = window.location.origin;

// API Service Class
class MovieBookingAPI {
    constructor() {
        this.cache = {
            movies: {},
            theaters: {},
            bookings: {}
        };
    }

    // Generic API request method
    async request(endpoint, options = {}) {
        const url = `${API_BASE_URL}/${endpoint}`;
        
        const config = {
            headers: {
                'Content-Type': 'application/json',
                ...options.headers
            },
            ...options
        };

        if (config.body && typeof config.body === 'object') {
            config.body = JSON.stringify(config.body);
        }

        try {
            const response = await fetch(url, config);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API request failed:', error);
            throw error;
        }
    }

    // Theater Methods
    async getTheaters(lat, lng, movieId = null) {
        let url = `theaters.php?lat=${lat}&lng=${lng}`;
        if (movieId) {
            url += `&movie_id=${movieId}`;
        }

        try {
            const data = await this.request(url);
            return data;
        } catch (error) {
            console.error('Error fetching theaters:', error);
            // Return sample data as fallback
            return {
                theaters: [
                    {
                        id: 1,
                        name: "PVR Cinemas: Forum Mall",
                        address: "Koramangala, Bangalore",
                        distance: "2.3 km",
                        price: 180
                    }
                ]
            };
        }
    }

    // Booking Methods
    async createBooking(bookingData) {
        try {
            const data = await this.request('booking.php', {
                method: 'POST',
                body: bookingData
            });
            return data;
        } catch (error) {
            console.error('Error creating booking:', error);
            throw error;
        }
    }

    async getBooking(bookingRef) {
        try {
            const data = await this.request(`booking.php?ref=${bookingRef}`);
            return data;
        } catch (error) {
            console.error('Error fetching booking:', error);
            throw error;
        }
    }
}

// Create global API instance
const movieAPI = new MovieBookingAPI();

// Add these methods to your MovieBookingAPI class in api.js

// Authentication methods
async register(userData) {
    try {
        const formData = new FormData();
        formData.append('action', 'register');
        formData.append('name', userData.name);
        formData.append('email', userData.email);
        formData.append('phone', userData.phone);
        formData.append('password', userData.password);
        formData.append('via', userData.via);

        const response = await fetch('auth.php', {
            method: 'POST',
            body: formData
        });
        
        return await response.json();
    } catch (error) {
        console.error('Registration error:', error);
        throw error;
    }
}

async verifyOTP(userId, otp, via) {
    try {
        const formData = new FormData();
        formData.append('action', 'verify_otp');
        formData.append('user_id', userId);
        formData.append('otp', otp);
        formData.append('via', via);

        const response = await fetch('auth.php', {
            method: 'POST',
            body: formData
        });
        
        return await response.json();
    } catch (error) {
        console.error('OTP verification error:', error);
        throw error;
    }
}

async login(credentials) {
    try {
        const formData = new FormData();
        formData.append('action', 'login');
        formData.append('email', credentials.email);
        formData.append('password', credentials.password);

        const response = await fetch('auth.php', {
            method: 'POST',
            body: formData
        });
        
        return await response.json();
    } catch (error) {
        console.error('Login error:', error);
        throw error;
    }
}

async resendOTP(userId, via) {
    try {
        const formData = new FormData();
        formData.append('action', 'resend_otp');
        formData.append('user_id', userId);
        formData.append('via', via);

        const response = await fetch('auth.php', {
            method: 'POST',
            body: formData
        });
        
        return await response.json();
    } catch (error) {
        console.error('Resend OTP error:', error);
        throw error;
    }
}

// Store session in localStorage
setSession(sessionData) {
    localStorage.setItem('moviebooking_session', JSON.stringify(sessionData));
}

// Get current session
getSession() {
    const session = localStorage.getItem('moviebooking_session');
    return session ? JSON.parse(session) : null;
}

// Clear session (logout)
clearSession() {
    localStorage.removeItem('moviebooking_session');
}

// Check if user is logged in
isLoggedIn() {
    const session = this.getSession();
    return session !== null;
}