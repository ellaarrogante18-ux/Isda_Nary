# 🌊 IsdaNary - Fish Inventory Management System

A comprehensive inventory management system designed specifically for fish vendors to track stock, record sales, manage expenses, and analyze business performance. Features a beautiful aquatic blue theme that perfectly represents the marine business environment.

## 🐟 Features

### 🧾 Inventory Management
- Add, edit, and delete fish entries
- Track fish name, type, quantity available, and price per kilo
- Upload fish images
- **🔍 Advanced Search**: Search by name, type, or description
- **📊 Stock Filtering**: Filter by In Stock, Low Stock, Out of Stock
- Automatic stock updates when sales are made
- Low stock alerts with color-coded indicators
- Prevent overselling with real-time stock validation

### 💰 Sales Management
- Record sales transactions with customer information
- **⚖️ Quantity Fractions**: Quick selection (1/4 kg, 1/2 kg, 3/4 kg, etc.)
- **💸 Discount System**: Percentage or fixed amount discounts
- **🔍 Sales Search**: Search by customer name, product, or notes
- **📅 Time Filters**: Today, Yesterday, This Week, This Month, etc.
- Automatic price calculation based on quantity and price per kilo
- Link sales to specific fish inventory
- Edit or delete sales records
- Automatic inventory deduction
- Sales history and filtering

### 📊 Expense Management
- Track daily business expenses by category
- Upload receipt images
- Categorized expense tracking (fuel, ice, equipment, etc.)
- Expense filtering and reporting

### 👩‍💼 User Management
- Secure user authentication
- Individual vendor accounts
- Data privacy and separation between users
- Business profile management

### 📈 Dashboard and Analytics
- Real-time business insights
- Daily, weekly, and monthly sales reports
- Profit/loss calculations
- Top-selling fish analysis
- Visual sales trends

## 🛠️ Technology Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel's built-in authentication
- **File Storage**: Local storage for images
- **Build Tools**: Vite for asset compilation

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL 5.7+ or MariaDB
- XAMPP (recommended for local development)

## 🚀 Installation

### 1. Clone or Download
```bash
# If using Git
git clone <repository-url> fish_inventory
cd fish_inventory

# Or extract the downloaded files to c:\xampp\htdocs\fish_inventory
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
# Copy the environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Setup
1. Create a MySQL database named `fish_inventory`
2. Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fish_inventory
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Database Migrations
```bash
php artisan migrate
```

### 7. Create Storage Link
```bash
php artisan storage:link
```

### 8. Build Assets
```bash
# For development
npm run dev

# For production
npm run build
```

### 9. Start the Application
```bash
# Start Laravel development server
php artisan serve

# Or use XAMPP and access via http://localhost/fish_inventory/public
```

## 📁 Project Structure

```
fish_inventory/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   └── RegisterController.php
│   │   ├── DashboardController.php
│   │   ├── FishController.php
│   │   ├── SaleController.php
│   │   └── ExpenseController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Fish.php
│   │   ├── Sale.php
│   │   └── Expense.php
│   └── Policies/
│       ├── FishPolicy.php
│       ├── SalePolicy.php
│       └── ExpensePolicy.php
├── database/
│   └── migrations/
│       ├── create_users_table.php
│       ├── create_fish_table.php
│       ├── create_sales_table.php
│       └── create_expenses_table.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       ├── fish/
│       ├── sales/
│       └── expenses/
├── routes/
│   └── web.php
├── public/
├── composer.json
├── package.json
└── README.md
```

## 🔧 Configuration

### Database Configuration
Update `.env` file with your database settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fish_inventory
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Application Settings
```env
APP_NAME="Fish Inventory System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
```

### File Storage
The system uses local storage for fish images and receipts. Make sure the `storage/app/public` directory is writable.

## 📖 Usage Guide

### Getting Started
1. Visit the application URL
2. Click "Get Started" or "Register"
3. Create your vendor account
4. Complete your business profile

### Managing Fish Inventory
1. Go to "Inventory" section
2. Click "Add New Fish"
3. Fill in fish details (name, type, quantity, price)
4. Upload an image (optional)
5. Save the fish entry

### Recording Sales
1. Go to "Sales" section
2. Click "Record New Sale"
3. Select the fish type
4. Enter quantity sold and customer details
5. The system automatically calculates total price and updates inventory

### Tracking Expenses
1. Go to "Expenses" section
2. Click "Add Expense"
3. Select expense category
4. Enter amount and description
5. Upload receipt image (optional)

### Viewing Reports
- Dashboard shows real-time business metrics
- Filter sales and expenses by date ranges
- View top-selling fish and profit analysis

## 🔐 Security Features

- User authentication and authorization
- Data isolation between vendors
- Input validation and sanitization
- CSRF protection
- Secure file uploads

## 🎨 Customization

### Styling
The system uses Tailwind CSS for styling. You can customize:
- Colors in `tailwind.config.js`
- Custom styles in `resources/css/app.css`

### Adding Features
- Controllers in `app/Http/Controllers/`
- Models in `app/Models/`
- Views in `resources/views/`
- Routes in `routes/web.php`

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `.env`
   - Ensure MySQL service is running
   - Verify database exists

2. **Permission Errors**
   - Make sure `storage/` and `bootstrap/cache/` are writable
   - Run `php artisan storage:link`

3. **Asset Loading Issues**
   - Run `npm run build`
   - Clear browser cache

4. **Migration Errors**
   - Check database connection
   - Run `php artisan migrate:fresh` (caution: this will delete all data)

### Debug Mode
Enable debug mode in `.env` for detailed error messages:
```env
APP_DEBUG=true
```

## 📞 Support

For support and questions:
- Check the troubleshooting section
- Review Laravel documentation
- Ensure all requirements are met

## 🎨 Design Theme

### Aquatic Blue Theme
IsdaNary features a beautiful aquatic blue/blue-green color scheme that perfectly represents the marine business environment:

- **🌊 Cyan**: Light aquatic blue for backgrounds and highlights
- **🐟 Teal**: Deep ocean blue-green for primary actions and accents  
- **💙 Blue**: Classic ocean blue for secondary elements
- **🎯 Professional**: Clean, modern design with excellent readability
- **🌊 Thematic**: Colors evoke ocean waves, deep sea, and coastal waters

### User Experience
- Calming aquatic colors create a peaceful work environment
- Consistent color language throughout the application
- High contrast ensures excellent readability
- Responsive design works on all devices

## 📄 License

This project is open-source software licensed under the MIT license.

## 🔄 Updates and Maintenance

### Regular Maintenance
- Backup database regularly
- Update dependencies periodically
- Monitor storage usage for uploaded images

### Performance Tips
- Use database indexing for large datasets
- Optimize images before upload
- Consider caching for better performance

## 🚀 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

**Happy Fish Selling! 🐟💼🌊**
