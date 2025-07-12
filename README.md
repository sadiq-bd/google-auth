<p align="left">
  <img src="https://api.sadiq.workers.dev/app/github/repo/google-auth/views" alt="Repo views" />
</p>

# Google Auth

A simple and efficient Google Authentication Library for PHP.

---

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Usage](#usage)
- [Configuration](#configuration)
- [API Reference](#api-reference)
- [Contributing](#contributing)
- [License](#license)

---

## Features

- 🔒 Easy integration with Google OAuth2
- 📦 Lightweight & dependency friendly
- 📝 Well-documented and simple API
- ⚡ Fast and secure authentication
- 🛡️ Follows best security practices

---

## Installation

Install via [Composer](https://getcomposer.org/):

```bash
composer require sadiq-bd/google-auth
```

---

## Quick Start

```php
require 'vendor/autoload.php';

use SadiqBd\GoogleAuth\GoogleAuth;

$googleAuth = new GoogleAuth(
    'YOUR_CLIENT_ID',
    'YOUR_CLIENT_SECRET',
    'YOUR_REDIRECT_URI'
);

// Redirect to Google OAuth
header('Location: ' . $googleAuth->getAuthUrl());
exit();
```

---

## Usage

### 1. Configure Google Console

- Go to [Google Cloud Console](https://console.cloud.google.com/apis/credentials)
- Create a new OAuth 2.0 Client ID
- Set your redirect URI

### 2. Authenticate and Get User Info

```php
// After redirect, handle the callback
if (isset($_GET['code'])) {
    $token = $googleAuth->fetchAccessToken($_GET['code']);
    $user = $googleAuth->getUserInfo($token['access_token']);
    // Do something with $user
}
```

---

## Configuration

| Option          | Description                  |
|-----------------|-----------------------------|
| `client_id`     | Google OAuth2 Client ID      |
| `client_secret` | Google OAuth2 Client Secret  |
| `redirect_uri`  | Your App's Redirect URI     |

---

## API Reference

| Method              | Description                                         |
|---------------------|-----------------------------------------------------|
| `getAuthUrl()`      | Generates the Google OAuth2 authorization URL       |
| `fetchAccessToken()`| Exchanges code for an access token                  |
| `getUserInfo()`     | Retrieves authenticated user's information          |

---

## Contributing

Contributions are welcome! Please open issues or submit pull requests for improvements or bug fixes.

---

## License

This project is licensed under the [MIT License](LICENSE).

---
