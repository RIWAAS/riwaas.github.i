# Riwaa's Guest House Website

A modern, responsive website for Riwaa's Guest House in Shillong, Meghalaya, featuring interactive booking system and e-commerce functionality.

## Features

### Frontend
- **Responsive Design**: Optimized for all devices (desktop, tablet, mobile)
- **Interactive Carousel**: Showcasing rooms and facilities
- **Shopping Cart System**: Add rooms and services to cart
- **Booking Modal**: Complete checkout process with form validation
- **Smooth Animations**: AOS library integration for scroll animations
- **Contact Form**: Direct messaging system

### Backend (PHP)
- **RESTful API**: Clean API endpoints for all operations
- **Database Integration**: MySQL database for storing bookings and room data
- **Booking Management**: Complete booking lifecycle management
- **Room Availability**: Real-time availability checking
- **Email Integration**: Contact form email notifications

## Installation

### Prerequisites
- Web server (Apache/Nginx)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

### Setup Instructions

1. **Clone/Download the project files**
2. **Database Setup**:
   ```sql
   # Import the database schema
   mysql -u your_username -p < database/schema.sql
   ```

3. **Configure Database Connection**:
   Edit `api/config/database.php` with your database credentials:
   ```php
   private $host = "localhost";
   private $db_name = "riwaas_guesthouse";
   private $username = "your_username";
   private $password = "your_password";
   ```

4. **Web Server Configuration**:
   - Place files in your web server document root
   - Ensure `.htaccess` files are enabled for Apache
   - Set proper permissions for PHP files

5. **Email Configuration**:
   Update email settings in `api/endpoints/contact.php` if needed

## API Endpoints

### Bookings
- `GET /api/bookings` - Get all bookings
- `GET /api/bookings?id={id}` - Get specific booking
- `POST /api/bookings` - Create new booking
- `PUT /api/bookings` - Update booking status

### Rooms
- `GET /api/rooms` - Get all available rooms
- `GET /api/rooms?id={id}` - Get specific room
- `GET /api/rooms?check_availability=1&room_id={id}&check_in={date}&check_out={date}` - Check availability

### Contact
- `POST /api/contact` - Send contact form message

## Database Schema

### Tables
- **rooms**: Store room information, pricing, and amenities
- **bookings**: Store customer bookings and payment information

### Key Features
- JSON storage for flexible amenities and booking items
- Indexed fields for optimal query performance
- Booking status tracking (pending, confirmed, cancelled, completed)

## File Structure

```
/
├── index.html              # Main website file
├── main.js                 # Frontend JavaScript
├── Styles.css              # Main stylesheet
├── package.json            # Node.js dependencies
├── api/                    # Backend API
│   ├── config/
│   │   └── database.php    # Database configuration
│   ├── models/
│   │   ├── Booking.php     # Booking model
│   │   └── Room.php        # Room model
│   ├── endpoints/
│   │   ├── bookings.php    # Booking API endpoints
│   │   ├── rooms.php       # Room API endpoints
│   │   └── contact.php     # Contact form endpoint
│   └── .htaccess          # API routing configuration
├── database/
│   └── schema.sql         # Database schema
└── img/                   # Image assets
```

## Usage

### For Customers
1. Browse available rooms and services
2. Add desired items to cart
3. Proceed to checkout with personal details
4. Select payment method and confirm booking
5. Receive booking confirmation

### For Administrators
- Access booking data through API endpoints
- Monitor room availability
- Manage booking status updates
- Receive contact form submissions via email

## Responsive Design

The website is fully responsive with breakpoints for:
- **Desktop**: 1024px and above
- **Tablet**: 768px - 1023px
- **Mobile**: 480px - 767px
- **Small Mobile**: Below 480px

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Security Features

- Input sanitization and validation
- SQL injection prevention using prepared statements
- XSS protection headers
- CORS configuration for API access
- Form validation on both frontend and backend

## Performance Optimizations

- Optimized images and media
- Efficient CSS and JavaScript
- Database indexing for fast queries
- Caching headers for static assets
- Minified and compressed resources

## Contact Information

**Riwaa's Guest House**
- Location: Laitumkhrah, Demseiniong, Shillong, Meghalaya
- Phone: +91-9366181466, +91-9436106079
- Email: guesthouseriwaas@gmail.com

## License

© 2025 Riwaa's Guest House. All rights reserved.