<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieBooking - Your Ultimate Movie Experience</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6a11cb;
            --secondary: #2575fc;
            --accent: #ff4d94;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .navbar {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&h=500&q=60');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
        }
        
        .movie-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            height: 100%;
        }
        
        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
        }
        
        .movie-poster {
            height: 300px;
            object-fit: cover;
            width: 100%;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(106, 17, 203, 0.3);
        }
        
        .screen {
            background-color: #e9ecef;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            transition: all 0.2s;
        }
        
        .seat.available {
            background-color: #28a745;
            color: white;
        }
        
        .seat.booked {
            background-color: #dc3545;
            color: white;
            cursor: not-allowed;
        }
        
        .seat.selected {
            background-color: #ffc107;
            color: black;
            transform: scale(1.05);
        }
        
        .seat.vip {
            background-color: #6f42c1;
            color: white;
        }
        
        .seat.available:hover {
            background-color: #20c997;
        }
        
        .booking-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
            border: none;
        }
        
        .booking-header {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 15px;
        }
        
        .form-control {
            border-radius: 5px;
            padding: 12px;
            border: 1px solid #ced4da;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.25);
        }
        
        .legend {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            margin: 0 15px 10px;
        }
        
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 8px;
        }
        
        .theater-card {
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .theater-card:hover, .theater-card.selected {
            border-color: var(--primary);
            transform: translateY(-5px);
        }
        
        .confirmation-page {
            text-align: center;
            padding: 60px 0;
        }
        
        .confirmation-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        
        footer {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
        
        @media (max-width: 768px) {
            .seat {
                width: 30px;
                height: 30px;
                font-size: 10px;
            }
            
            .movie-poster {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-ticket-alt me-2"></i>MovieBooking
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Theaters</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Offers</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <button class="btn btn-outline-light me-2">Sign In</button>
                    <button class="btn btn-light">Register</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Book Your Movie Experience</h1>
            <p class="lead">Discover the latest blockbusters and reserve your seats in just a few clicks</p>
            <button class="btn btn-primary btn-lg mt-3">Explore Now</button>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- Upcoming Movies Section -->
        <section class="mb-5">
            <h2 class="section-title">Upcoming Movies</h2>
            <div class="row" id="movies-container">
                <!-- Movies will be dynamically loaded here -->
            </div>
        </section>

        <!-- Booking Form Section (Initially Hidden) -->
        <section class="mb-5" id="booking-section" style="display: none;">
            <div class="row">
                <div class="col-lg-8">
                    <div class="booking-card mb-4">
                        <div class="booking-header">
                            <h4 class="mb-0" id="booking-movie-title">Movie Title</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="" class="img-fluid rounded mb-3" alt="Movie Poster" id="booking-poster">
                                </div>
                                <div class="col-md-6">
                                    <p id="booking-description"></p>
                                    <div class="mb-3">
                                        <strong>Duration:</strong> <span id="booking-duration"></span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Genre:</strong> <span id="booking-genre"></span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Rating:</strong> <span id="booking-rating"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="mt-4">Select Theater</h5>
                            <div class="row" id="theaters-container">
                                <!-- Theaters will be dynamically loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Showtimes Section (Initially Hidden) -->
                    <div class="booking-card mb-4" id="showtimes-section" style="display: none;">
                        <div class="booking-header">
                            <h4 class="mb-0">Available Showtimes</h4>
                        </div>
                        <div class="card-body">
                            <div class="row" id="showtimes-container">
                                <!-- Showtimes will be dynamically loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Seats Selection Section (Initially Hidden) -->
                    <div class="booking-card mb-4" id="seats-section" style="display: none;">
                        <div class="booking-header">
                            <h4 class="mb-0">Select Your Seats</h4>
                        </div>
                        <div class="card-body">
                            <div class="screen">SCREEN</div>
                            
                            <div class="text-center mb-4">
                                <div class="legend">
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #28a745;"></div>
                                        <span>Available</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #dc3545;"></div>
                                        <span>Booked</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #ffc107;"></div>
                                        <span>Selected</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #6f42c1;"></div>
                                        <span>VIP</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="seat-layout text-center" id="seat-layout">
                                <!-- Seats will be dynamically generated here -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="booking-card sticky-top" style="top: 20px;">
                        <div class="booking-header">
                            <h4 class="mb-0">Booking Summary</h4>
                        </div>
                        <div class="card-body">
                            <div id="booking-summary">
                                <p class="text-center">Select a movie to start booking</p>
                            </div>
                            
                            <hr>
                            
                            <form id="booking-form">
                                <div class="form-group mb-3">
                                    <label for="name">Your Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" required>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: 100%;" disabled id="complete-booking">Complete Booking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Confirmation Page (Initially Hidden) -->
        <section class="confirmation-page" id="confirmation-section" style="display: none;">
            <div class="container">
                <div class="confirmation-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Booking Confirmed!</h2>
                <p class="lead">Thank you for your booking. A confirmation email has been sent to your email address.</p>
                <div class="mt-4" id="confirmation-details">
                    <!-- Booking details will be shown here -->
                </div>
                <button class="btn btn-primary mt-4" id="new-booking-btn">Book Another Movie</button>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-ticket-alt me-2"></i>MovieBooking</h5>
                    <p>Your ultimate movie experience booking platform. Find the latest movies, showtimes, and theaters near you.</p>
                </div>
                <div class="col-md-2">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Home</a></li>
                        <li><a href="#" class="text-white">Movies</a></li>
                        <li><a href="#" class="text-white">Theaters</a></li>
                        <li><a href="#" class="text-white">Offers</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Cinema St, Movie City</li>
                        <li><i class="fas fa-phone me-2"></i> (077) 1975-8118</li>
                        <li><i class="fas fa-envelope me-2"></i> info@moviebooking.com</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <div class="d-flex">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-4">
            <p class="text-center mb-0">© 2023 MovieBooking. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample data with working image URLs
        const movies = [
            {
                id: 1,
                title: "Demon Slayer: Kimetsu no Yaiba",
                description: "Tanjiro Kamado, a boy who becomes a demon slayer after his family is slaughtered and his sister turned into a demon.",
                genre: "Animation, Action, Fantasy",
                duration: "117 minutes",
                rating: "8.7/10",
                poster: "https://m.media-amazon.com/images/M/MV5BZjZjNzI5MDctY2Y4YS00NmM4LTljMmItZTFkOTExNGI3ODRhXkEyXkFqcGdeQXVyNjc3MjQzNTI@._V1_FMjpg_UX1000_.jpg",
                basePrice: 280,
                theaters: [
                    {
                        id: 1,
                        name: "City Cinema",
                        location: "City Center",
                        showtimes: ["10:00 AM", "1:30 PM", "5:00 PM", "8:30 PM"]
                    },
                    {
                        id: 2,
                        name: "Movie Palace",
                        location: "Downtown",
                        showtimes: ["11:00 AM", "2:30 PM", "6:00 PM", "9:30 PM"]
                    }
                ]
            },
            {
                id: 2,
                title: "War of the Worlds",
                description: "As Earth is invaded by alien tripods, one family fights for survival in this sci-fi action thriller.",
                genre: "Sci-Fi, Action, Thriller",
                duration: "116 minutes",
                rating: "7.5/10",
                poster: "https://m.media-amazon.com/images/M/MV5BNDUyODAzNDI1Nl5BMl5BanBnXkFtZTcwMDA2NDAzMw@@._V1_FMjpg_UX1000_.jpg",
                basePrice: 300,
                theaters: [
                    {
                        id: 3,
                        name: "Star Theater",
                        location: "Mall of Entertainment",
                        showtimes: ["10:30 AM", "2:00 PM", "5:30 PM", "9:00 PM"]
                    },
                    {
                        id: 4,
                        name: "Galaxy Cineplex",
                        location: "Westside Plaza",
                        showtimes: ["11:30 AM", "3:00 PM", "6:30 PM", "10:00 PM"]
                    }
                ]
            },
            {
                id: 3,
                title: "The Smurfs",
                description: "When the evil wizard Gargamel chases the tiny blue Smurfs out of their village, they tumble into a portal that takes them to New York City.",
                genre: "Animation, Comedy, Family",
                duration: "103 minutes",
                rating: "7.2/10",
                poster: "https://m.media-amazon.com/images/M/MV5BMTg2NzgyMjU0Nl5BMl5BanBnXkFtZTcwNTA4MDk5NA@@._V1_FMjpg_UX1000_.jpg",
                basePrice: 250,
                theaters: [
                    {
                        id: 5,
                        name: "Family Cinema",
                        location: "Eastside Mall",
                        showtimes: ["10:00 AM", "12:30 PM", "3:00 PM", "5:30 PM"]
                    },
                    {
                        id: 6,
                        name: "Kids Theater",
                        location: "Fun World",
                        showtimes: ["11:00 AM", "1:30 PM", "4:00 PM", "6:30 PM"]
                    }
                ]
            },
            {
                id: 4,
                title: "The Batman",
                description: "When a killer targets Gotham's elite with a series of sadistic games, Batman must investigate the city's hidden corruption.",
                genre: "Action, Crime, Drama",
                duration: "176 minutes",
                rating: "8.9/10",
                poster: "https://m.media-amazon.com/images/M/MV5BMDdmMTBiNTYtMDIzNi00NGVlLWIzMDYtZTk3MTQ3NGQxZGEwXkEyXkFqcGdeQXVyMzMwOTU5MDk@._V1_FMjpg_UX1000_.jpg",
                basePrice: 320,
                theaters: [
                    {
                        id: 1,
                        name: "City Cinema",
                        location: "City Center",
                        showtimes: ["12:00 PM", "4:00 PM", "8:00 PM"]
                    },
                    {
                        id: 4,
                        name: "Galaxy Cineplex",
                        location: "Westside Plaza",
                        showtimes: ["1:00 PM", "5:00 PM", "9:00 PM"]
                    }
                ]
            }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            const moviesContainer = document.getElementById('movies-container');
            const bookingSection = document.getElementById('booking-section');
            const showtimesSection = document.getElementById('showtimes-section');
            const seatsSection = document.getElementById('seats-section');
            const confirmationSection = document.getElementById('confirmation-section');
            const bookingForm = document.getElementById('booking-form');
            const completeBookingBtn = document.getElementById('complete-booking');
            const newBookingBtn = document.getElementById('new-booking-btn');
            
            let selectedMovie = null;
            let selectedTheater = null;
            let selectedShowtime = null;
            let selectedSeats = [];
            let currentBasePrice = 0;
            const vipSurcharge = 50;
            const maxSeats = 6;
            
            // Load movies
            function loadMovies() {
                moviesContainer.innerHTML = '';
                
                movies.forEach(movie => {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-4';
                    
                    col.innerHTML = `
                        <div class="card movie-card h-100">
                            <img src="${movie.poster}" class="card-img-top movie-poster" alt="${movie.title}">
                            <div class="card-body">
                                <h5 class="card-title">${movie.title}</h5>
                                <p class="card-text">${movie.genre}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-primary">${movie.rating}</span>
                                    <span class="text-muted">${movie.duration}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <button class="btn btn-primary w-100 book-btn" data-movie-id="${movie.id}">Book Tickets</button>
                            </div>
                        </div>
                    `;
                    
                    moviesContainer.appendChild(col);
                });
                
                // Add event listeners to book buttons
                document.querySelectorAll('.book-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const movieId = parseInt(this.getAttribute('data-movie-id'));
                        selectMovie(movieId);
                    });
                });
            }
            
            // Select a movie
            function selectMovie(movieId) {
                selectedMovie = movies.find(movie => movie.id === movieId);
                
                // Show booking section
                bookingSection.style.display = 'block';
                
                // Scroll to booking section
                bookingSection.scrollIntoView({ behavior: 'smooth' });
                
                // Update booking details
                document.getElementById('booking-movie-title').textContent = selectedMovie.title;
                document.getElementById('booking-poster').src = selectedMovie.poster;
                document.getElementById('booking-description').textContent = selectedMovie.description;
                document.getElementById('booking-duration').textContent = selectedMovie.duration;
                document.getElementById('booking-genre').textContent = selectedMovie.genre;
                document.getElementById('booking-rating').textContent = selectedMovie.rating;
                
                // Load theaters
                loadTheaters();
                
                // Update booking summary
                updateBookingSummary();
            }
            
            // Load theaters
            function loadTheaters() {
                const theatersContainer = document.getElementById('theaters-container');
                theatersContainer.innerHTML = '';
                
                selectedMovie.theaters.forEach(theater => {
                    const col = document.createElement('div');
                    col.className = 'col-md-6 mb-3';
                    
                    col.innerHTML = `
                        <div class="card theater-card" data-theater-id="${theater.id}">
                            <div class="card-body">
                                <h5 class="card-title">${theater.name}</h5>
                                <p class="card-text">${theater.location}</p>
                                <button class="btn btn-outline-primary select-theater">Select Theater</button>
                            </div>
                        </div>
                    `;
                    
                    theatersContainer.appendChild(col);
                });
                
                // Add event listeners to theater buttons
                document.querySelectorAll('.select-theater').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const card = this.closest('.theater-card');
                        const theaterId = parseInt(card.getAttribute('data-theater-id'));
                        selectTheater(theaterId);
                    });
                });
            }
            
            // Select a theater
            function selectTheater(theaterId) {
                selectedTheater = selectedMovie.theaters.find(theater => theater.id === theaterId);
                
                // Highlight selected theater
                document.querySelectorAll('.theater-card').forEach(card => {
                    card.classList.remove('selected');
                });
                document.querySelector(`.theater-card[data-theater-id="${theaterId}"]`).classList.add('selected');
                
                // Show showtimes section
                showtimesSection.style.display = 'block';
                
                // Load showtimes
                loadShowtimes();
                
                // Update booking summary
                updateBookingSummary();
            }
            
            // Load showtimes
            function loadShowtimes() {
                const showtimesContainer = document.getElementById('showtimes-container');
                showtimesContainer.innerHTML = '';
                
                selectedTheater.showtimes.forEach((showtime, index) => {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    
                    col.innerHTML = `
                        <div class="card showtime-card" data-showtime-index="${index}">
                            <div class="card-body text-center">
                                <h5 class="card-title">${showtime}</h5>
                                <button class="btn btn-outline-primary select-showtime">Select</button>
                            </div>
                        </div>
                    `;
                    
                    showtimesContainer.appendChild(col);
                });
                
                // Add event listeners to showtime buttons
                document.querySelectorAll('.select-showtime').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const card = this.closest('.showtime-card');
                        const showtimeIndex = parseInt(card.getAttribute('data-showtime-index'));
                        selectShowtime(showtimeIndex);
                    });
                });
            }
            
            // Select a showtime
            function selectShowtime(showtimeIndex) {
                selectedShowtime = selectedTheater.showtimes[showtimeIndex];
                
                // Highlight selected showtime
                document.querySelectorAll('.showtime-card').forEach(card => {
                    card.classList.remove('selected');
                });
                document.querySelector(`.showtime-card[data-showtime-index="${showtimeIndex}"]`).classList.add('selected');
                
                // Show seats section
                seatsSection.style.display = 'block';
                
                // Generate seats
                generateSeats();
                
                // Update booking summary
                updateBookingSummary();
                
                // Enable complete booking button
                completeBookingBtn.disabled = false;
            }
            
            // Generate seats
            function generateSeats() {
                const seatLayout = document.getElementById('seat-layout');
                seatLayout.innerHTML = '';
                
                // Define theater layout
                const rows = [
                    { id: 'A', type: 'standard', seats: 10 },
                    { id: 'B', type: 'standard', seats: 10 },
                    { id: 'C', type: 'standard', seats: 10 },
                    { id: 'D', type: 'standard', seats: 10 },
                    { id: 'E', type: 'standard', seats: 10 },
                    { id: 'F', type: 'standard', seats: 10 },
                    { id: 'G', type: 'vip', seats: 8 },
                    { id: 'H', type: 'vip', seats: 8 }
                ];
                
                // Generate random booked seats for demonstration
                const randomBookedSeats = generateRandomBookedSeats(rows);
                
                // Create seat layout
                rows.forEach(row => {
                    const rowDiv = document.createElement('div');
                    rowDiv.className = 'row mb-2 justify-content-center';
                    
                    for (let i = 1; i <= row.seats; i++) {
                        const seatNumber = `${row.id}${i}`;
                        const isBooked = randomBookedSeats.includes(seatNumber);
                        const isVip = row.type === 'vip';
                        
                        const seatCol = document.createElement('div');
                        seatCol.className = 'col-auto p-1';
                        
                        const seat = document.createElement('div');
                        seat.className = `seat ${isBooked ? 'booked' : isVip ? 'vip' : 'available'}`;
                        seat.setAttribute('data-seat', seatNumber);
                        seat.textContent = seatNumber;
                        
                        if (!isBooked) {
                            seat.addEventListener('click', function() {
                                const seatNumber = this.getAttribute('data-seat');
                                const index = selectedSeats.indexOf(seatNumber);
                                
                                if (index === -1) {
                                    // Select seat
                                    if (selectedSeats.length < maxSeats) {
                                        selectedSeats.push(seatNumber);
                                        this.classList.add('selected');
                                    } else {
                                        alert(`You can select maximum ${maxSeats} seats.`);
                                        return;
                                    }
                                } else {
                                    // Deselect seat
                                    selectedSeats.splice(index, 1);
                                    this.classList.remove('selected');
                                }
                                
                                updateBookingSummary();
                            });
                        }
                        
                        seatCol.appendChild(seat);
                        rowDiv.appendChild(seatCol);
                    }
                    
                    seatLayout.appendChild(rowDiv);
                });
                
                // Reset selected seats
                selectedSeats = [];
                updateBookingSummary();
            }
            
            // Generate random booked seats for demonstration
            function generateRandomBookedSeats(rows) {
                const bookedSeats = [];
                const totalSeats = rows.reduce((total, row) => total + row.seats, 0);
                const bookedCount = Math.floor(totalSeats * 0.3); // 30% of seats booked
                
                for (let i = 0; i < bookedCount; i++) {
                    const randomRow = rows[Math.floor(Math.random() * rows.length)];
                    const randomSeat = Math.floor(Math.random() * randomRow.seats) + 1;
                    const seatNumber = `${randomRow.id}${randomSeat}`;
                    
                    if (!bookedSeats.includes(seatNumber)) {
                        bookedSeats.push(seatNumber);
                    }
                }
                
                return bookedSeats;
            }
            
            // Update booking summary
            function updateBookingSummary() {
                const bookingSummary = document.getElementById('booking-summary');
                
                if (!selectedMovie) {
                    bookingSummary.innerHTML = '<p class="text-center">Select a movie to start booking</p>';
                    return;
                }
                
                let summaryHTML = `
                    <div class="d-flex mb-3">
                        <img src="${selectedMovie.poster}" alt="${selectedMovie.title}" style="width: 80px; height: 120px; object-fit: cover; border-radius: 5px;">
                        <div class="ms-3">
                            <h5>${selectedMovie.title}</h5>
                            <p class="mb-0">${selectedMovie.genre}</p>
                            <p class="mb-0">${selectedMovie.duration}</p>
                        </div>
                    </div>
                `;
                
                if (selectedTheater) {
                    summaryHTML += `
                        <p><strong>Theater:</strong> ${selectedTheater.name}</p>
                        <p><strong>Location:</strong> ${selectedTheater.location}</p>
                    `;
                }
                
                if (selectedShowtime) {
                    summaryHTML += `<p><strong>Showtime:</strong> ${selectedShowtime}</p>`;
                }
                
                if (selectedSeats.length > 0) {
                    summaryHTML += `
                        <p><strong>Seats:</strong> ${selectedSeats.join(', ')}</p>
                        <p><strong>Total Amount:</strong> ₹${calculateTotal()}</p>
                    `;
                }
                
                bookingSummary.innerHTML = summaryHTML;
            }
            
            // Calculate total amount
            function calculateTotal() {
                if (!selectedMovie) return 0;
                
                let total = 0;
                selectedSeats.forEach(seat => {
                    // Check if seat is VIP (starts with G or H in this example)
                    const isVip = /^[GH]/.test(seat);
                    total += selectedMovie.basePrice + (isVip ? vipSurcharge : 0);
                });
                
                return total;
            }
            
            // Form submission
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (selectedSeats.length === 0) {
                    alert('Please select at least one seat.');
                    return;
                }
                
                if (!selectedMovie || !selectedTheater || !selectedShowtime) {
                    alert('Please complete your booking selection.');
                    return;
                }
                
                // Get form values
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;
                
                // In a real application, you would send this data to the server
                // and send a confirmation email to the user
                
                // Show confirmation page
                bookingSection.style.display = 'none';
                confirmationSection.style.display = 'block';
                
                // Scroll to confirmation section
                confirmationSection.scrollIntoView({ behavior: 'smooth' });
                
                // Display confirmation details
                const confirmationDetails = document.getElementById('confirmation-details');
                confirmationDetails.innerHTML = `
                    <div class="card mx-auto" style="max-width: 500px;">
                        <div class="card-body">
                            <h4 class="card-title">Booking Details</h4>
                            <p><strong>Movie:</strong> ${selectedMovie.title}</p>
                            <p><strong>Theater:</strong> ${selectedTheater.name} (${selectedTheater.location})</p>
                            <p><strong>Showtime:</strong> ${selectedShowtime}</p>
                            <p><strong>Seats:</strong> ${selectedSeats.join(', ')}</p>
                            <p><strong>Total Amount:</strong> ₹${calculateTotal()}</p>
                            <p><strong>Booked By:</strong> ${name}</p>
                            <p><strong>Email:</strong> ${email}</p>
                            <p><strong>Phone:</strong> ${phone}</p>
                            <p class="text-success mt-3"><i class="fas fa-envelope me-2"></i>A confirmation email has been sent to ${email}</p>
                        </div>
                    </div>
                `;
            });
            
            // New booking button
            newBookingBtn.addEventListener('click', function() {
                // Reset everything
                confirmationSection.style.display = 'none';
                bookingSection.style.display = 'none';
                selectedMovie = null;
                selectedTheater = null;
                selectedShowtime = null;
                selectedSeats = [];
                
                // Reset form
                bookingForm.reset();
                
                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            
            // Initialize the page
            loadMovies();
        });
    </script>
</body>
</html>