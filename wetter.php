<?php
// Konfigurierbare Teile

// Passwort für den Zugriff auf das Skript
$zugriffspasswort = 'DeinPasswort';

// Überprüfen, ob das korrekte Passwort übergeben wurde
if (!isset($_GET['passwort']) || $_GET['passwort'] !== $zugriffspasswort) {
    die('Zugriff verweigert.');
}

// OpenAI API-Schlüssel
$openai_api_key = 'YOUR_OPENAI_API_KEY_HERE';

// Twilio Account SID
$twilio_account_sid = 'YOUR_TWILIO_ACCOUNT_SID_HERE';

// Twilio Auth Token
$twilio_auth_token = 'YOUR_TWILIO_AUTH_TOKEN_HERE';

// Twilio WhatsApp-Nummer 
$twilio_whatsapp_number = 'whatsapp:+11111111';

// WhatsApp-Nummer des Kindes
$child_whatsapp_number = 'whatsapp:+41790000000';

// Prompt für OpenAI
$prompt = <<<EOT
Erstelle mit untenstehender Wettervorhersage eine Nachricht für Luca. Luca geht mit dem Fahrrad zur Schule und deine Nachricht soll ihm helfen, was er anzuziehen hat. 
Je nach Wetter können das kurze Hosen oder bis zu gefütterten langen Hosen mit Regenschutz und Schal und Mütze und Handschuhe sein.

Gib ihm als erstes einen Überblick, wie das Wetter um 08:00 Uhr, um 12:00 Uhr und um 16:00 Uhr ist. Berechne auch die gefühlte Temperatur anhand Wind, Sonneneinstrahlung und Luftfeuchtigkeit.

Nutze anschließend 1-5 passende Emojis. Im JSON hast du unter anderem die Angabe "iconDay". Hier eine Auswahl an dazu passenden Emojis: 1=☀️, 10=🌨️, 101=🌟, 102=🌥️, 103=☁️, 104=☁️, 105=🌥️, 106=🌦️, 107=🌨️, 108=🌨️, 109=🌦️, 11=🌨️, 110=🌨️, 111=🌨️, 112=🌩️, 113=🌩️, 114=🌧️, 115=🌧️, 116=❄️, 117=🌧️, 118=🌨️, 119=❄️, 12=⛈️, 120=🌧️, 121=🌨️, 122=❄️, 123=🌩️, 124=🌩️, 125=⛈️, 126=☁️, 127=☁️, 128=🌫️, 129=🌦️, 13=⛈️, 130=❄️, 131=🌨️, 132=🌦️, 133=🌨️, 134=🌨️, 135=☁️, 14=🌧️, 15=🌧️, 16=❄️, 17=🌧️, 18=🌨️, 19=❄️, 2=🌤️, 20=🌧️, 21=🌨️, 22=❄️, 23=⛈️, 24=🌩️, 25=⛈️, 26=☁️, 27=☁️, 28=🌫️, 29=🌦️, 3=⛅, 30=❄️, 31=🌨️, 32=🌦️, 33=🌦️, 34=❄️, 35=☁️, 4=☁️, 5=🌥️, 6=🌦️, 7=🌨️, 8=❄️, 9=🌦️

Anschließend kommen die Kleidertipps.

Beachte: Er geht mit dem Velo zur Schule, ein Regenschirm ist keine Option.
Beachte: Nutze die daten von MeteoSwiss für die Vorhersage. Um die gefühlte Temperatur zu berechne, nutze zusätzlich die Luftfeuchtigkeit von Open-Meteo.
Beachte: Im JSON hast du als erstes den Aktuellen Tag, anschliessend kommen die weiteren Tage. Es kann sein, dass ich dir auch Hinweise gebe, wie das Wetter gestern war. Nutze in diesem Fall diese Angaben auch.
Beachte: Ich schicke anschliessend automatisch diese Nachricht mit Whatsapp. Nutze bitte entsprechende Formatierungen. Und die Grüsse kommen von "Papi"
Beachte: Sollte im JSON das Feld "warnings" ausgefüllt sein, handelt es sich um einen Wetteralarm. Gib diesen dann aus, sollte dieser für Luca relevant sein. Gib auch einen ganz kurzen Ausblick auf den morgigen Tag, so im Stil von: Morgen wird es etwas wärmer.
Am Ende kannst du noch ein tolles Zitat einfügen.
EOT;

// Ab hier beginnt das Skript

// Pfad zur Datei, in der die Wetterdaten gespeichert werden
$data_file = 'weather_data.txt';

// Zeitzonen-Einstellung
date_default_timezone_set('Europe/Zurich');

// Aktuelles Datum
$today = date('Y-m-d');

// Wetterdaten von MeteoSwiss abrufen
$weather_url = 'https://app-prod-ws.meteoswiss-app.ch/v1/plzDetail?plz=452200';
$weather_json = file_get_contents($weather_url);
$weather_data = json_decode($weather_json, true);

// Wetterdaten von Open-Meteo abrufen (für Luftfeuchtigkeit)
$open_meteo_url = 'https://api.open-meteo.com/v1/forecast?latitude=47.2305&longitude=7.5295&hourly=temperature_2m,relative_humidity_2m,snowfall,snow_depth,visibility&past_days=1&forecast_days=1';
$open_meteo_json = file_get_contents($open_meteo_url);
$open_meteo_data = json_decode($open_meteo_json, true);

// Funktion zum Laden der gespeicherten Wetterdaten
function loadStoredWeatherData($data_file) {
    if (file_exists($data_file)) {
        $data = file_get_contents($data_file);
        return json_decode($data, true);
    }
    return [];
}

// Funktion zum Speichern der Wetterdaten
function saveWeatherData($data_file, $weather_data_to_save) {
    $data_json = json_encode($weather_data_to_save);
    file_put_contents($data_file, $data_json);
}

// Gespeicherte Wetterdaten laden
$stored_weather_data = loadStoredWeatherData($data_file);

// Wetterdaten von gestern abrufen, falls vorhanden
$yesterday = date('Y-m-d', strtotime('-1 day'));
$yesterday_data = isset($stored_weather_data[$yesterday]) ? $stored_weather_data[$yesterday] : null;

// Aktuelle Wetterdaten extrahieren (wichtige Informationen)
$current_weather = [
    'date' => $today,
    'temperatureMax' => $weather_data['forecast'][0]['temperatureMax'],
    'temperatureMin' => $weather_data['forecast'][0]['temperatureMin'],
    'precipitation' => $weather_data['forecast'][0]['precipitation'],
];

// Wetterdaten speichern (nur heute und gestern behalten)
$stored_weather_data[$today] = $current_weather;

// Nur Daten von gestern und heute behalten
if (count($stored_weather_data) > 2) {
    foreach ($stored_weather_data as $date => $data) {
        if ($date != $today && $date != $yesterday) {
            unset($stored_weather_data[$date]);
        }
    }
}

// Wetterdaten speichern
saveWeatherData($data_file, $stored_weather_data);

// Berechnung der Temperaturdifferenz zu gestern
$temperature_difference = null;
$temperature_trend = '';
if ($yesterday_data) {
    $temperature_difference = $current_weather['temperatureMax'] - $yesterday_data['temperatureMax'];

    if ($temperature_difference > 0) {
        $temperature_trend = "Zusätzlich: Heute wird es " . abs($temperature_difference) . " Grad wärmer als gestern.\n\n";
    } elseif ($temperature_difference < 0) {
        $temperature_trend = "Zusätzlich: Heute wird es " . abs($temperature_difference) . " Grad kälter als gestern.\n\n";
    } else {
        $temperature_trend = "Zusätzlich: Heute wird es genauso warm wie gestern.\n\n";
    }
}

// Füge den Temperaturtrend zum Prompt hinzu
$full_prompt = $prompt . "\n\n{$temperature_trend}Wettervorhersage (JSON-Daten):\n\nMeteoSwiss Daten:\n$weather_json\n\nOpen-Meteo Daten:\n$open_meteo_json";

// OpenAI API aufrufen

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $openai_api_key,
]);

$post_fields = json_encode([
    'model' => 'gpt-4o',
    'messages' => [
        ['role' => 'system', 'content' => 'Du bist ein hilfreicher Assistent, der auf Deutsch schreibt. Du bist professioneller Meteorologe.'],
        ['role' => 'user', 'content' => $full_prompt],
    ],
    'max_tokens' => 4000,
    'temperature' => 0.7,
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo "cURL Error: " . $error_msg;
    $message = '';
} else {
    $openai_response = json_decode($response, true);

    if (isset($openai_response['error'])) {
        echo "OpenAI API Error: " . $openai_response['error']['message'];
        $message = '';
    } else {
        if (isset($openai_response['choices'][0]['message']['content'])) {
            $message = $openai_response['choices'][0]['message']['content'];
        } else {
            echo "Keine Antwort von OpenAI erhalten.";
            $message = '';
        }
    }
}

curl_close($ch);

// Prüfen, ob eine Nachricht vorhanden ist
if (!empty($message)) {
    // WhatsApp-Nachricht über Twilio senden

    $twilio_url = 'https://api.twilio.com/2010-04-01/Accounts/' . $twilio_account_sid . '/Messages.json';

    $data = [
        'To' => $child_whatsapp_number,
        'From' => $twilio_whatsapp_number,
        'Body' => $message,
    ];

    $post = http_build_query($data);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $twilio_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $twilio_account_sid . ':' . $twilio_auth_token);

    $twilio_response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        echo "Twilio cURL Error: " . $error_msg;
    } else {
        $twilio_response_data = json_decode($twilio_response, true);
        if (isset($twilio_response_data['error_code']) && $twilio_response_data['error_code'] != null) {
            echo "Twilio API Error: " . $twilio_response_data['message'];
        } else {
            echo "Nachricht gesendet: " . $message;
        }
    }

    curl_close($ch);

} else {
    echo "Keine Nachricht zu senden.";
}
?>
