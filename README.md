# Cinema Website

Welcome to the **Cinema Website**! This platform allows users to browse movies, view showtimes, and book tickets for their favorite films. Whether you're looking to watch the latest blockbuster or enjoy a classic, this website makes it easy to book tickets for cinemas near you.

---

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Getting Started](#getting-started)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Acknowledgments](#acknowledgments)

---

## Features

- **User Registration & Login**: Users can create an account, log in, and manage their profiles.
- **Movie Listings**: Browse a list of currently playing movies along with their descriptions, ratings, and showtimes.
- **Search & Filter**: Easily search for movies by name, genre, or date, and filter showtimes by cinema location.
- **Seat Selection**: Book tickets by selecting specific seats in a cinema hall.
- **Payment Integration**: A secure online payment gateway to complete ticket purchases.
- **Booking History**: View your past bookings and upcoming movie reservations.
- **Admin Panel**: Admins can manage movie listings, showtimes, and user bookings.

---

## Technologies Used

- **Frontend**:
  - HTML
  - CSS
  - JavaScript (jQuery, AJAX)
  - Bootstrap (for responsive design)
  
- **Backend**:
  - PHP
  - MySQL (for database management)
  
- **Additional Tools**:
  - GitHub for version control
  - XAMPP for local server and MySQL database
  - Payment API (e.g., Stripe or PayPal) for ticket payments

---

## Getting Started

To get started with this project, clone the repository to your local machine.

### Prerequisites
- **XAMPP** (or another local server stack) to run PHP and MySQL.
- A **web browser** (e.g., Chrome, Firefox) to view the website.
- A **text editor** (e.g., VSCode, Sublime) to modify the source code.

---

## Installation

### Steps to run the project locally:

1. **Download and Install XAMPP**:
   - If you haven’t already installed XAMPP, download it from [here](https://www.apachefriends.org/index.html).

2. **Set up the Database**:
   - Open **phpMyAdmin** by navigating to `http://localhost/phpmyadmin` in your browser.
   - Create a new database called `cinemadb`.
   - Import the SQL file (`database.sql`) from the project directory into phpMyAdmin to set up the necessary tables.

3. **Move the Project Files**:
   - Place the cloned repository in the `htdocs` folder of your XAMPP installation (e.g., `C:\xampp\htdocs\cinema`).

4. **Start the Servers**:
   - Launch **XAMPP Control Panel**, and start both **Apache** and **MySQL**.

5. **Access the Website**:
   - Open your browser and go to `http://localhost/cinema/` to see the website in action.

---

## Usage

- **User Registration**: Sign up with your email and create a password.
- **Login**: Use your credentials to log in and access available movies and showtimes.
- **Search and Filter Movies**: Use the search bar to find movies by name and apply filters for showtimes, genres, and locations.
- **Book Tickets**: Choose your movie, select a showtime, pick seats, and complete the payment.
- **Admin Dashboard**: Admins can log in to manage movie listings, showtimes, and user bookings.

---

## Contributing

Contributions are welcome! If you'd like to contribute to the project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -am 'Add feature'`).
5. Push your changes to the branch (`git push origin feature-branch`).
6. Open a pull request.

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## Acknowledgments

- This project was created as part of a learning exercise in web development.
- Special thanks to **Bootstrap** for making responsive design easy.
- Thanks to the **PHP** and **MySQL** communities for their extensive documentation and support.
- Thanks to **XAMPP** for providing a great local development environment.

