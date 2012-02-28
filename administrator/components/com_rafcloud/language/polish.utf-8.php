<?php

define( "RC_WORDS", "Tagi" );
define( "RC_PUBLISHED", "Opublikowane" );
define( "RC_COUNTER", "Licznik" );
define( "RC_FONTSIZE", "Rozmiar czcionki (%)" );
define( "RC_SETTINGS", "Configuracja Raf Cloud." );
define( "RC_PARAMETERS", "Parametry:" );
define( "RC_CONFIG_UNWRITABLE", "Nie można zapisać pliku konfiguracji settings.php" );
define( "RC_MSG_REMEMBER", "Sprawdź czy wszystkie ustawienia są prawidłowe.<br> Po zapisaniu ustawień kliknij na [Buduj listę słów].<br> Pamiętaj aby zainstalowac i umieścić na swojej stornie <a target=\"_blank\" href=\"http://www.joomla.royy.net/index.php/Download-document/42-Raf-Cloud-Module.html\" >moduł Raf Cloud </a> ." );
define( "RC_CONFIGURATION", "Ustawienia" );
define( "RC_DEFAULT_PUBLISHED", "Domyślnie publikuj słowa:" );
define( "RC_DEFAULT_PUBLISHED_DES", "Nowo dodawane słowa będą domyślnie publikowane." );
define( "RC_SAVED", "Pomyślnie zapisano konfigurację!" );
define( "RC_DEFAULT_MIN_COUNTER", "Minimalny licznik wystąpień" );
define( "RC_DEFAULT_MIN_COUNTER_DES", "Słowa którę występują częściej niż ustawiona wartość zostaną dodane do listy." );
define( "RC_DEFAULT_MIN_LEN", "Minimalna długosć słowa" );
define( "RC_DEFAULT_MIN_LEN_DES", "Słowa o długości mniejszej niż ustawiona nie zostaną dodane do listy." );
define( "RC_DEFAULT_MAX_LEN", "Maksymalna długosć słowa" );
define( "RC_DEFAULT_MAX_LEN_DES", "Słowa o długości większej niż ustawiona nie zostaną dodane do listy.(max. 200)" );
define( "RC_DEFAULT_MIN_FONT", "Minimalna wielkośc fontu (%)" );
define( "RC_DEFAULT_MIN_FONT_DES", "Wartość musi być większa od 0, nie większa od maksymalnej wielkości fontu." );
define( "RC_DEFAULT_MAX_FONT", "Maksymalna wielkość fontu (%)" );
define( "RC_DEFAULT_MAX_FONT_DES", "Wartość musi być większa od minimalnej wielkości fontu." );
define( "RC_YES", "Tak" );
define( "RC_NO", "Nie" );
define( "RC_CONFIG", "Parametry" );
define( "RC_BUILD", "Buduj listę słów" );
define( "RC_ERASE", "Usuwanie" );
define( "RC_ERASE_DES", "Dla bezpieczeństwa - jeli chcesz usunąc wszystkie dane z tabeli, zaznacz dowolne słowo i nacisnij klawisz Usuń wszystko." );
define( "RC_ERASE_ALL", "Usuń wszystko." );
define( "RC_ERASE_UNPUBL", "Usuń niepub." );
define( "RC_ERASE_SELECTED", "Usuń wybrane" );
define( "RC_ADDED", "Dodano" );
define( "RC_WORD_LENGHT", "Długość" );
define( "RC_WORD_LIST", "Lista tagów" );
define( "RC_DEFAULT_BLACKLIST", "Wykluczone słowa (blacklist)" );
define( "RC_DEFAULT_BLACKLIST_DES", "Słowa pomijane przy tworzeniu listy." );
define( "RC_DEFAULT_BLACKLIST_WORDS", "
abym,
bardzo,
byli,
czym,
dalej,
dlatego,
do,
dopiero,
dopóty,
dotąd,
i,
ich,
ja,
jaki,
jakie,
jakis,
jakiś,
jednak,
jest,
jeszcze,
kiedy,
komuś,
kto,
ktoś,
które,
który,
mieli,
mnie,
moszoomthumb,
my,
na,
nad,
nawet,
nie,
niej,
niestety,
o,
odtąd,
on,
ona,
oni,
ono,
pan,
pani,
państwo,
po,
pod,
ponieważ,
przed,
przez,
przy,
się,
sobie,
stamtąd,
stąd,
szybko,
tak,
taki,
tam,
tamten,
tamtędy,
tego,
ten,
to,
tu,
tutaj,
ty,
tylko,
tędy,
w,
więc,
wolno,
wtedy,
wtenczas,
wy,
z,
żeby,
ów,
ówdzie" );
define( "RC_DEFAULT_BLACKLIST_LOAD", "<-ŁADUJ DOMYŚLNE SŁOWA" );
define( "RC_BLACKLIST_ADD", "Dodaj do blacklist" );
define( "RC_OK_UPLOAD", "Pomyslnie zapisano plik." );
define( "RC_ERROR_UPLOAD", "Błąd pobrania pliku." );
define( "RC_ERROR_UPLOAD_1", "Błąd rozszerzenia pliku. Plik musi posiadać rozszerzenie " );
define( "RC_ERROR_UPLOAD_2", "Błąd zapisu pliku do katalogu." );
define( "RC_UPLOAD_PLUGIN_DES", "Wgraj plik .php z pluginem " );
define( "RC_UPLOAD", "Zapisz" );
define( "RC_ERROR_PLUGIN", "Plugin ma nieprawidłowy format lub jest uszkodzony." );
define( "RC_PLUGINS", "Lista pluginów " );
define( "RC_REMOVE_PLUGIN", "Usuń plugin" );
define( "RC_NEED_PLUGIN", "Potrzebujesz plugin? Sprawdź na <a target=\"_blank\" href=\"http://www.joomla.royy.net\"> stronie projektu </a> lub spytaj na forum.");
define( "RC_BUGS_FEATURES", "Błędy i propozycje nowych funkcji mozesz umieszczać na forum na <a target=\"_blank\" href=\"http://www.joomla.royy.net\"> stronie projektu </a>" );
define( "RC_DEFAULT_RUN_PERIOD", "Uruchamiaj co " );
define( "RC_DEFAULT_RUN_PERIOD_DES", "Co jaki okres czasu ma być uruchamiana aktualizacja listy słów." );
define( "RC_DEFAULT_RUN_DATE", "Data i czas startu (DD-MM-RRRR)" );
define( "RC_DEFAULT_LIMIT", "Limit słów raportu e-mail" );
define( "RC_DEFAULT_LIMIT_DES", "Ogranicza liczbę słów przesłanych w raporcie, słowa segregowane są według ilosci wystąpień.");
define( "RC_DEFAULT_ADMIN_EMAIL", "e-mail" );
define( "RC_DEFAULT_ADMIN_EMAIL_DES", "Wysyła raport o nowo dodanych słowach na podany e-mail." );
define( "RC_TITLE_EMAIL", "Raport z automatycznego uruchomienia Raf Cloud" );
define( "RC_BODY_EMAIL", "Nowe słowa dodane do bazy:" );
define( "RC_FOOTER_EMAIL", "Liczba słów  w raporcie %2, limit słów %1 .\nAby zobaczyć wszystkie nowe słowa wejdź do listy słów komponentu i posegreguj słowa według kolumny Nowe." );
define( "RC_DAYS", "Dni " );
define( "RC_HOURS", "Godziny" );
define( "RC_LAST_RUN", "Ostatnie uruchomienie" );
define( "RC_NEXT_RUN", "Następne uruchomienie" );
define( "RC_CLEAR_RUN", "zastosuj nowe ustawienia czasu uruchomienia" );
define( "RC_NEW", "Nowe" );
define( "RC_GENTIME", "Czas generowania" );
define( "RC_DEFAULT_RUN", "Automatyczne uaktualnianie bazy słów" );
define( "RC_DEFAULT_RUN_INFO", "Jesli chcesz uaktywnic musisz dodać następujący wpis przed końcowym  &lt;/body&gt; w pliku index.php szablonu witryny :<br>(Witryna -> Szablony -> Szablon witryna -> Edytuj HTML)<br>");
define( "RC_DEFAULT_RUN_CODE", "
&lt;?php<br />
if (file_exists(JPATH_SITE.&quot;/components/com_rafcloud/rafcloud.php&quot;))
<br>{<br />
echo &quot;&lt;img src=\&quot;&quot;.\$this->baseurl.&quot;/index2.php?option=com_rafcloud\&quot; width=\&quot;0\&quot; height=\&quot;0\&quot; alt=\&quot;\&quot; /&gt;&quot;;<br />
}<br />
?>" );
define( "RC_DEBUG_MODE", "Jeśli masz problemy z automatycznym uaktualnianiem kliknij na link aby zobaczyc komunikaty o błędach:" );
define( "RC_DEFAULT_PREG", "Zaawansowane opcje preg_replace" );
define( "RC_DEFAULT_PREG_DES", "Wpisz tutaj własne ustawienia pattern funcji preg_replace. <br>Domyślna wartość: <b>/[,.\-:><()!?\\n\"'{}]/</b><br> w razie problemów ze specjalnymi znakami spróbuj:  <b>/[^a-zA-Z0-9\\200-\\377]/</b>" );
define( "RC_CONFIG_ERROR_LOCK", "Błąd blokady pliku konfiguracji! " );
define( "RC_CLOSE", "Zamknij " );

define( "RC_DEFAULT_WHITELIST", "Biała lista (whitelist)" );
define( "RC_DEFAULT_WHITELIST_DES", "Słowa (oddzielone przecinakmi) zawsze dodawane do listy. Domyślnie są oznaczone jako opublikowane." );

define( "RC_DEFAULT_STRTOLOWER", "Funkcja zmiany znaków:" );
define( "RC_DEFAULT_STRTOLOWER_DESC", "Funkcja zmiany zanaków z dużych na małe. Zmień na strtolower tylko jesli masz problemy ze znakami specjalnymi." );

define( "RC_TAB_WORDS", "Słowa" );
define( "RC_TAB_KEYS", "Klucze" );
define( "RC_TAB_SCHEDULER", "Planowanie" );
define( "RC_TAB_TOOLS", "Narzędzia" );
define( "RC_ORIGINAL", "Oryginalny" );

define( "RC_DEFAULT_ENABLE", "Ładuj słowa" );
define( "RC_KEYS_ENABLE", "Ładuj klucze" );
define( "RC_KEYS_PUBLISHED", "Automatycznie publikuj klucze" );
define( "RC_KEY_MIN_COUNTER", "Minimalny licznik wystąpień" );
define( "RC_KEY_MIN_COUNTER_DES", "Klucze występujące częściej niż ustawiona wartość zostaną dodane do listy." );
define( "RC_KEY_MIN_LEN", "Minimalna długość klucza" );
define( "RC_KEY_MIN_LEN_DES", "Klucze o długości większej niż ustawiona będą dodane do listy." );

define( "RC_KEY_MAX_LEN", "Maksymalna długość klucza." );
define( "RC_KEY_MAX_LEN_DES", "Klucze o długości mniejszej niż ustawiona będą dodane do listy.(max. 200)" );
define( "RC_KEY_WHITELIST_DES", "Akceptowane słowa oddzielone przecinkiem. Domyślnie publikowane." );
define( "RC_GENERAL", "Ogólne" );
define( "RC_TYPE", "Typ" );

define( "RC_WORD", "Słowo" );
define( "RC_KEY", "Klucz" );
define( "RC_WORD_KEY", "Słowo/Klucz" );
define( "RC_W_WORD", "Słowo(Whitelist)" );
define( "RC_W_KEY", "Klucz(Whitelist)" );
define( "RC_FILTER", "Filtruj" );
define( "RC_CANCEL", "Anuluj" );
define( "RC_SAVE", "Zapisz" );

define( "RC_OLD_CONFIG", "Znaleziono plik settings.php. Załadowano ustawienia konfiguracji." );

define( "RC_KEY_PREG_DES", "Wpisz tutaj własne ustawienia pattern funcji preg_replace. <br>Domyślna wartość: <b>/[.\-:><()!?\\n\"']/</b>" );
define( "RC_KEY_ASWORD", "Podziel tagi" );
define( "RC_KEY_ASWORD_DES", "Potraktuje tagi jak słowa." );

define( "RC_REMOVE", "Usuń baze RC" );
define( "RC_REMOVE_DATABASE", "Usuń wszystkie tabele komponentu Raf Cloud." );
define( "RC_REMOVE_ACC", "Potwierdź" );
define( "RC_REMOVED", "Tabele zostały usunięte, odinstaluj komponent!" );
define( "RC_ERROR", "Błąd przy usuwaniu tabel!" );
define( "RC_ERROR_REMCONF", "Błąd przy usuwaniu settings.php!" );
define( "RC_PLUGINS_DES", "Nazwa" );
define( "RC_PLUGINS_FILE", "Plik" );
define( "RC_PLUGINS_PUBL", "Opublikowany" );

// 2.0.2

define( "RC_RUN_DEBUG", "Kliknij na ten link aby zobaczyć informacje działaniu programu:" );
define( "RC_MEMUS", "Pamięć" );
define( "RC_SEF", "SEF URLs" );
define( "RC_SH404SEFPREF", "sh404sef prefix ( domyślnie : RC-tag ):" );
define( "RC_SH404SEFPREF_DES", "Możesz ustawić swój własny prefix. Pamiętaj aby uruchomić <b>Purge
SEF Urls</b> w komponencie sh404sef." );
define( "RC_CACHE", "Caching" );
define( "RC_CACHE_DES", "Uruchom cache aby zmniejszyć użycie pamięci." );

// 3.0
define( "RC_DONATION", "Jeśli chcesz przyczynić się do rozwoju tego orpogramowania możesz wspomóc nas klikając na poniższy przycisk" );

define( "RC_SH404SEFLINK", "sh404sef link:" );
define( "RC_SH404SEF_WORD", "Tag (np: /RC-tag/joomla.html)" );
define( "RC_SH404SEF_ID", "Index (np: /RC-tag/843.html)" );
define( "RC_SH404SEF_BOTH", "Tag+Index (np: /RC-tag/joomla-843.html)" );

?>