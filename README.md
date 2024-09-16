# Wettervorhersage-Skript für mit KI und WhatsApp

Dieses PHP-Skript erstellt eine personalisierte Wettervorhersage für dein Kind und sendet ihm eine Nachricht über WhatsApp mit Kleidertipps basierend auf den aktuellen Wetterbedingungen.
Wetterdaten sind von MeteoSchweiz und OpenMeteo

## Inhaltsverzeichnis

- [Beschreibung](#beschreibung)
- [Funktionen](#funktionen)
- [Voraussetzungen](#voraussetzungen)
- [Installation](#installation)
- [Konfiguration](#konfiguration)
- [Verwendung](#verwendung)
- [Sicherheitshinweise](#sicherheitshinweise)
- [Lizenz](#lizenz)
- [Kontakt](#kontakt)
- [Danksagung](#danksagung)

## Beschreibung

Das Skript ruft Wetterdaten von **MeteoSwiss** und **Open-Meteo** ab, verarbeitet diese und generiert eine Nachricht, die über die **Twilio WhatsApp API** an Luca gesendet wird. Die Nachricht enthält einen Überblick über das Wetter zu bestimmten Tageszeiten und gibt Kleidertipps basierend auf der gefühlten Temperatur, die Wind, Sonneneinstrahlung und Luftfeuchtigkeit berücksichtigt.

## Funktionen

- Ruft aktuelle Wetterdaten ab
- Berechnet die gefühlte Temperatur unter Berücksichtigung von Wind und Luftfeuchtigkeit
- Generiert personalisierte Kleidertipps
- Sendet die Nachricht automatisch über WhatsApp
- Einfache Konfiguration und Anpassung

## Voraussetzungen

- **PHP** 7.0 oder höher
- Zugang zu einem Webserver oder zur Kommandozeile
- **OpenAI API Key**
- **Twilio Account SID** und **Auth Token**
- **Twilio WhatsApp Nummer**
- WhatsApp-Nummer des Empfängers (Luca)

## Installation

1. **Repository klonen oder herunterladen**

   ```bash
   git clone https://github.com/IhrBenutzername/wettervorhersage-luca.git
   ```

2. **Zum Verzeichnis navigieren**

   ```bash
   cd wettervorhersage-luca
   ```

## Konfiguration

Öffnen Sie die Datei `wetter_skript.php` und konfigurieren Sie die folgenden Parameter am Anfang der Datei:

```php
<?php
// Konfigurierbare Teile

// Passwort für den Zugriff auf das Skript
$zugriffspasswort = 'IhrSicheresPasswort';

// OpenAI API-Schlüssel
$openai_api_key = 'YOUR_OPENAI_API_KEY_HERE';

// Twilio Account SID
$twilio_account_sid = 'YOUR_TWILIO_ACCOUNT_SID_HERE';

// Twilio Auth Token
$twilio_auth_token = 'YOUR_TWILIO_AUTH_TOKEN_HERE';

// Twilio WhatsApp-Nummer (z.B. 'whatsapp:+1234567890')
$twilio_whatsapp_number = 'whatsapp:+1234567890';

// WhatsApp-Nummer des Empfängers (z.B. 'whatsapp:+0987654321')
$child_whatsapp_number = 'whatsapp:+0987654321';

// Prompt für OpenAI
$prompt = <<<EOT
[Ihr benutzerdefinierter Prompt hier]
EOT;

//PLZ - Passe auf Zeile 57 die Postleitzahl an. Füge deiner Postleitzahl noch die 00 hinzu. Für Rüttenen wäre das 452200
$weather_url = 'https://app-prod-ws.meteoswiss-app.ch/v1/plzDetail?plz=452200';
```

**Hinweis:** Ersetzen Sie die Platzhalter durch Ihre tatsächlichen Zugangsdaten.

## Verwendung

### Über den Webbrowser

Rufen Sie das Skript über Ihren Webbrowser auf und übergeben Sie das Passwort als URL-Parameter:

```
http://Ihre-Domain.tld/wetter_skript.php?passwort=IhrSicheresPasswort
```

### Über die Kommandozeile

Führen Sie das Skript von der Kommandozeile aus:

```bash
php wetter_skript.php passwort=IhrSicheresPasswort
```

**Hinweis:** Stellen Sie sicher, dass das Skript im Webserver-Verzeichnis liegt, wenn Sie es über den Browser aufrufen möchten.

## Sicherheitshinweise

- **Passwortschutz:** Das Skript ist mit einem einfachen Passwortschutz versehen. Verwenden Sie ein starkes Passwort und nutzen Sie HTTPS, um die Übertragung zu sichern.
- **API-Schlüssel:** Bewahren Sie Ihre API-Schlüssel sicher auf und veröffentlichen Sie sie nicht öffentlich oder in Repositories.
- **Zugangsbeschränkung:** Erwägen Sie zusätzliche Sicherheitsmaßnahmen wie IP-Beschränkungen oder eine erweiterte Authentifizierung.

## Lizenz

Dieses Projekt steht unter der [MIT Lizenz](LICENSE).

## Kontakt

Für Fragen oder Unterstützung kontaktieren Sie bitte [Ihr Name](mailto:ihre-email@example.com).

## Danksagung

- [Open-Meteo](https://open-meteo.com/) für die Bereitstellung der Wetterdaten
- [MeteoSwiss](https://www.meteoswiss.admin.ch/) für zusätzliche Wetterinformationen
- [OpenAI](https://openai.com/) für die API
- [Twilio](https://www.twilio.com/) für die WhatsApp API

---

# Weather Forecast Script for Luca

This PHP script creates a personalized weather forecast for Luca and sends him a message via WhatsApp with clothing tips based on the current weather conditions.

## Table of Contents

- [Description](#description)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Security Notes](#security-notes)
- [License](#license)
- [Contact](#contact)
- [Acknowledgments](#acknowledgments)

## Description

The script fetches weather data from **MeteoSwiss** and **Open-Meteo**, processes it, and generates a message that is sent to Luca via the **Twilio WhatsApp API**. The message includes an overview of the weather at specific times of the day and provides clothing tips based on the perceived temperature, which considers wind, solar radiation, and humidity.

## Features

- Fetches current weather data
- Calculates perceived temperature considering wind and humidity
- Generates personalized clothing tips
- Sends the message automatically via WhatsApp
- Easy configuration and customization

## Requirements

- **PHP** 7.0 or higher
- Access to a web server or command line
- **OpenAI API Key**
- **Twilio Account SID** and **Auth Token**
- **Twilio WhatsApp Number**
- Recipient's WhatsApp number (Luca)

## Installation

1. **Clone or download the repository**

   ```bash
   git clone https://github.com/YourUsername/weather-forecast-luca.git
   ```

2. **Navigate to the directory**

   ```bash
   cd weather-forecast-luca
   ```

## Configuration

Open the `weather_script.php` file and configure the following parameters at the beginning of the file:

```php
<?php
// Configurable Parts

// Password for script access
$zugriffspasswort = 'YourSecurePassword';

// OpenAI API Key
$openai_api_key = 'YOUR_OPENAI_API_KEY_HERE';

// Twilio Account SID
$twilio_account_sid = 'YOUR_TWILIO_ACCOUNT_SID_HERE';

// Twilio Auth Token
$twilio_auth_token = 'YOUR_TWILIO_AUTH_TOKEN_HERE';

// Twilio WhatsApp Number (e.g., 'whatsapp:+1234567890')
$twilio_whatsapp_number = 'whatsapp:+1234567890';

// Recipient's WhatsApp Number (e.g., 'whatsapp:+0987654321')
$child_whatsapp_number = 'whatsapp:+0987654321';

// Prompt for OpenAI
$prompt = <<<EOT
[Your custom prompt here]
EOT;
```

**Note:** Replace the placeholders with your actual credentials.

## Usage

### Via Web Browser

Access the script through your web browser and pass the password as a URL parameter:

```
http://your-domain.com/weather_script.php?passwort=YourSecurePassword
```

### Via Command Line

Run the script from the command line:

```bash
php weather_script.php passwort=YourSecurePassword
```

**Note:** Ensure that the script is located in the web server directory if you wish to access it via a browser.

## Security Notes

- **Password Protection:** The script uses a simple password protection. Use a strong password and employ HTTPS to secure the transmission.
- **API Keys:** Keep your API keys secure and do not expose them publicly or in repositories.
- **Access Restriction:** Consider additional security measures like IP restrictions or enhanced authentication.

## License

This project is licensed under the [MIT License](LICENSE).

## Contact

For questions or support, please contact [Your Name](mailto:your-email@example.com).

## Acknowledgments

- [Open-Meteo](https://open-meteo.com/) for providing weather data
- [MeteoSwiss](https://www.meteoswiss.admin.ch/) for additional weather information
- [OpenAI](https://openai.com/) for the API
- [Twilio](https://www.twilio.com/) for the WhatsApp API

---

**Hinweis/Note:** Dieses Skript wurde für persönliche Zwecke entwickelt. Bitte stellen Sie sicher, dass Sie alle Nutzungsbedingungen und Richtlinien der verwendeten APIs einhalten.

---
