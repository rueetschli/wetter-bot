# Was soll ich Anziehen-Wetter-Skript mit KI und WhatsApp

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

Das Skript ruft Wetterdaten von **MeteoSwiss** und die Luftfeuchtigkeitsprognose (Wichtig für die gefühlte Temp.) von **Open-Meteo** (warum auch immer die nicht bei MeteoSchweiz dabei ist) ab, verarbeitet diese und generiert eine Nachricht, die über die **Twilio WhatsApp API** an dein Kind gesendet wird. Die Nachricht enthält einen **Überblick über das Wetter mit Emojis** zu bestimmten Tageszeiten und gibt **Kleidertipps basierend auf der gefühlten Temperatur**, die Wind, Sonneneinstrahlung und Luftfeuchtigkeit berücksichtigt.

## Funktionen

- Ruft aktuelle Wetterdaten ab
- Berechnet die gefühlte Temperatur unter Berücksichtigung von Wind und Luftfeuchtigkeit
- Generiert personalisierte Kleidertipps
- Sendet die Nachricht automatisch über WhatsApp
- Einfache Konfiguration und Anpassung
- Relevante Wetteralarme von Meteo Schweiz sind integriert (Frost wegen Pflanzenschäden werden ignoriert, Schneestürme werden angezeigt)

## Voraussetzungen

- **PHP** 7.0 oder höher
- Zugang zu einem Webserver oder zur Kommandozeile
- **OpenAI API Key**
- **Twilio Account SID** und **Auth Token**
- **Twilio WhatsApp Nummer**
- WhatsApp-Nummer des Empfängers

## Installation

1. **Repository klonen oder herunterladen**

   ```bash
   git clone https://github.com/rueetschli/wetter-bot.git
   ```

2. **Zum Verzeichnis navigieren**

   ```bash
   cd wetter-bot
   ```

## Konfiguration

Öffnen Sie die Datei `wetter.php` und konfigurieren Sie die folgenden Parameter am Anfang der Datei:

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

// Postleitzahl für MeteoSwiss (Die 00, welche MeteoSwiss nutzt wird automatisch ergänzt)
$postal_code = '4522';

// Koordinaten (Breitengrad und Längengrad) für Open-Meteo
$latitude = '47.2305';
$longitude = '7.5295';

// Prompt für OpenAI
$prompt = <<<EOT
[Ihr benutzerdefinierter Prompt hier]
EOT;

```

**Hinweis:** Ersetzen Sie die Platzhalter durch Ihre tatsächlichen Zugangsdaten.

## Verwendung

### Über einen Cronjob

Um automatisch jeden Morgen um 06.30 von Montag bis Freitag eine Nachricht zu verschicken gehst du wie folgt vor:
Öffne das Crontab-Bearbeitungsprogramm, indem du folgenden Befehl im Terminal ausführst:
```
crontab -e
```
Wenn du zum ersten Mal einen Cronjob einrichtest, wirst du möglicherweise gefragt, welchen Editor du verwenden möchtest. Wähle einfach deinen bevorzugten Texteditor (z.B. nano oder vim).
Füge am Ende der Datei die folgende Zeile hinzu:
```
30 6 * * 1-5 /usr/bin/curl -s "http://deinedomain.com/pfad/zu/deinem/wetter.php?passwort=DeinPasswort" >/dev/null 2>&1
```
Oder nutze einen Cronjob dienst deiner Wahl. Z.b. [Cronjob.de](https://www.cronjob.de/)

### Über den Webbrowser

Rufen Sie das Skript über Ihren Webbrowser auf und übergeben Sie das Passwort als URL-Parameter:

```
http://Ihre-Domain.tld/wetter.php?passwort=IhrSicheresPasswort
```

### Über die Kommandozeile

Führen Sie das Skript von der Kommandozeile aus:

```bash
php wetter.php passwort=IhrSicheresPasswort
```

**Hinweis:** Stellen Sie sicher, dass das Skript im Webserver-Verzeichnis liegt, wenn Sie es über den Browser aufrufen möchten.

## Sicherheitshinweise

- **Passwortschutz:** Das Skript ist mit einem einfachen Passwortschutz versehen. Verwenden Sie ein starkes Passwort und nutzen Sie HTTPS, um die Übertragung zu sichern.
- **API-Schlüssel:** Bewahren Sie Ihre API-Schlüssel sicher auf und veröffentlichen Sie sie nicht öffentlich oder in Repositories.
- **Zugangsbeschränkung:** Erwägen Sie zusätzliche Sicherheitsmaßnahmen wie IP-Beschränkungen oder eine erweiterte Authentifizierung.

## Lizenz

Dieses Projekt steht unter der [MIT Lizenz](LICENSE).

## Danksagung

- [Open-Meteo](https://open-meteo.com/) für die Bereitstellung der Wetterdaten
- [MeteoSwiss](https://www.meteoswiss.admin.ch/) für zusätzliche Wetterinformationen
- [OpenAI](https://openai.com/) für die API
- [Twilio](https://www.twilio.com/) für die WhatsApp API

---
![thumbnail_Bildschirmfoto 2024-09-16 um 14 02 06](https://github.com/user-attachments/assets/af1c0486-8314-4e7e-a1ce-2ef1ce0111cb)
---

# Weather Forecast Script

This PHP script creates a personalized weather forecast and sends him a message via WhatsApp with clothing tips based on the current weather conditions.

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

The script fetches weather data from **MeteoSwiss** and **Open-Meteo**, processes it, and generates a message that is sent via the **Twilio WhatsApp API**. The message includes an overview of the weather at specific times of the day and provides clothing tips based on the perceived temperature, which considers wind, solar radiation, and humidity.

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
- Recipient's WhatsApp number 

## Installation

1. **Clone or download the repository**

   ```bash
   git clone https://github.com/YourUsername/weather-forecast.git
   ```

2. **Navigate to the directory**

   ```bash
   cd weather-forecast
   ```

## Configuration

Open the `weather.php` file and configure the following parameters at the beginning of the file:

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

// Postleitzahl for MeteoSwiss 
$postal_code = '4522';

// Koordinaten (Breitengrad und Längengrad) for Open-Meteo
$latitude = '47.2305';
$longitude = '7.5295';

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
http://your-domain.com/weather.php?passwort=YourSecurePassword
```

### Via Command Line

Run the script from the command line:

```bash
php weather.php passwort=YourSecurePassword
```

**Note:** Ensure that the script is located in the web server directory if you wish to access it via a browser.

## Security Notes

- **Password Protection:** The script uses a simple password protection. Use a strong password and employ HTTPS to secure the transmission.
- **API Keys:** Keep your API keys secure and do not expose them publicly or in repositories.
- **Access Restriction:** Consider additional security measures like IP restrictions or enhanced authentication.

## License

This project is licensed under the [MIT License](LICENSE).


## Acknowledgments

- [Open-Meteo](https://open-meteo.com/) for providing weather data
- [MeteoSwiss](https://www.meteoswiss.admin.ch/) for additional weather information
- [OpenAI](https://openai.com/) for the API
- [Twilio](https://www.twilio.com/) for the WhatsApp API

---

**Hinweis/Note:** Dieses Skript wurde für persönliche Zwecke entwickelt. Bitte stellen Sie sicher, dass Sie alle Nutzungsbedingungen und Richtlinien der verwendeten APIs einhalten.

---
