# PHP Auth System - User Registration, Login, and Password Recovery

Welcome to the PHP Auth System! This project is a simple and robust authentication system for user registration, login/signup, and password recovery. Built with **PHP (OOP)**, **AJAX**, and **PHPMailer**, it provides essential features like URL-friendly paths, data validation, and email integration. This project is designed to be scalable, customizable, and easy to use.

---

## 📜 Project Overview

This project offers the following features:

- **User Registration/Login/Signup**
- **Forget Password/Reset Password**
- **AJAX-based data submission**
- **URL-friendly routes using `.htaccess`**
- **Data validation and error handling**
- **Email integration with PHPMailer**
- **Environment-based configuration with `.env` variables**

---

## 📦 Requirements

Make sure you have the following tools installed before starting the project:

- **PHP 7+**
- **Apache Server**
- **Composer** (for PHPMailer installation)
- **.htaccess** enabled on your Apache configuration

---

## 🚀 Project Installation

### Clone the Repository

Clone your project repository:

```bash
git clone https://github.com/johnvegagit/php-auth-system.git
```

You will need the main project, PHPMailer, and vlucas for email and dependencies.

##PHPMailer Installation

```bash
git clone https://github.com/PHPMailer/PHPMailer.git
```
##vlucas/parsedown Installation (Markdown Parser)

```bash
git clone https://github.com/paulmillr/parse.git
```
Make sure to place these dependencies in the appropriate paths as required.

---

Environment Configuration (.env file)

Configure your environment variables for proper system operation:

# Environment Configuration for Your Application

BASEURL="http://localhost/public_html/php-auth-system/"
BASEPTH="/opt/lampp/htdocs/public_html/php-auth-system/"

DATAMAIL="youremail@gmail.com"  # Your email address
DATAPASS="password"             # Your SMTP password

DBHOST="localhost"               # Database host
DBNAME="dbname"                 # Database name
DBUSER="root"                     # Database username
DBPASS="yourpassword"          # Database password

---

⚛️ How to Run the Project

    1. Make sure Apache and PHP are installed and running.
    2. Place the project under your Apache root path (e.g., /opt/lampp/htdocs).
    3. Configure your .htaccess properly to support SEO-friendly URLs.
    4. Use AJAX requests to communicate asynchronously with backend controllers to register/login/signup/reset passwords.

---

📚 Project Components
Authentication Logic

    - All authentication and database connection operations have been built with PHP OOP principles.
    - Handles user registration/login/signup.
    - Securely encrypts passwords and integrates PHPMailer for email notifications.

AJAX Communication

    - Seamlessly sends and fetches data from AJAX to PHP backend.
    - If there's an error, messages are returned in JSON format.

---

🤝 Free to Use & Open Source

This project is free to use, and you are free to modify, fork, and extend it as you wish.

    - It can be deployed in production environments or personal projects.
    - No commercial restrictions apply.
    - Use it at your own risk, and customize it according to your specific needs.

---

📄 License

This project does not have any restrictions. You are free to fork, modify, and use it commercially or personally without needing any licensing attribution. However, you should use it with your own caution and responsibility.

---

🛠️ Dependencies to Install (Recommended)

    - PHP: Latest version of PHP >= 7.4
    - Apache Web Server
    - PHPMailer: Handles email notifications for password recovery.
    - Composer (optional but highly recommended)

---

Happy coding 🚀💻 If you have questions or any bugs/issues, feel free to contribute to my repository or raise an issue.
